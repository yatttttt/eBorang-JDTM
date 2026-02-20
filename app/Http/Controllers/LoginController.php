<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\LogAktiviti;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request
     */
   public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'kata_laluan' => 'required|string|min:6',
        ], [
            // Tambah custom messages di sini
            'email.required' => 'E-mel diperlukan.',
            'email.email' => 'Format e-mel tidak sah.',
            'kata_laluan.required' => 'Kata laluan diperlukan.',
            'kata_laluan.min' => 'Kata laluan mesti sekurang-kurangnya 6 aksara.',
        ]);

        // Find user by email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !password_verify($credentials['kata_laluan'], $user->kata_laluan)) {
            return back()->withErrors(['email' => 'Butiran log masuk tidak sah'])->withInput();
        }

        // CHECK IF EMAIL IS VERIFIED
        if (is_null($user->email_verified_at)) {
            // Send verification email
            $this->sendVerificationEmail($user->email);
            
            // Store email in session for verification notice page
            $request->session()->put('verification_email', $user->email);
            
            // Redirect to verification notice page
            return redirect()->route('verification.notice');
        }

        // Log in user using session
        Auth::login($user);

        // Log the login activity
        LogAktiviti::create([
            'id_user' => $user->id_user,
            'tindakan' => "Pengguna login ke sistem dari IP: " . $request->ip()
        ]);

        // Redirect based on user role
        switch ($user->peranan) {
            case 'pentadbir_sistem':
                return redirect()->route('dashboard.pentadbir_sistem');
            case 'pengarah':
                return redirect()->route('dashboard.pengarah');
            case 'pegawai':
                return redirect()->route('dashboard.pegawai');
            default:
                return redirect()->route('dashboard.admin');
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $userId = Auth::id();
        $userName = Auth::user()->nama ?? 'Unknown';

        // Log the logout activity
        LogAktiviti::create([
            'id_user' => $userId,
            'tindakan' => "Pengguna logout dari sistem"
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        Log::info('>>> MASUK KE forgotPassword FUNCTION', ['email' => $request->email]);

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak dijumpai dalam sistem kami.',
        ]);

        // Generate reset token
        $token = Str::random(64);

        // Store token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Send reset email
        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));
        
        try {
            Mail::send('emails.reset_password', ['resetLink' => $resetLink], function ($message) use ($request) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($request->email);
                $message->subject('[eBorang JDTM] Reset Kata Laluan');
            });

            Log::info('Password reset email sent successfully', ['email' => $request->email]);
            return back()->with('reset_success', true);
        } catch (\Exception $e) {
            Log::error('Failed to send password reset email', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['email' => 'Gagal menghantar email. Sila cuba lagi.']);
        }
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request, $token)
    {
        return view('reset_password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'kata_laluan' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ], [
            'email.required' => 'E-mel diperlukan.',
            'email.email' => 'Format e-mel tidak sah.',
            'email.exists' => 'E-mel tidak dijumpai dalam sistem.',
            'kata_laluan.required' => 'Kata laluan diperlukan.',
            'kata_laluan.confirmed' => 'Kata laluan tidak sepadan.',
            'kata_laluan.min' => 'Kata laluan mesti sekurang-kurangnya 6 aksara.',
            'token.required' => 'Token diperlukan.',
        ]);

        // Check if token exists and is valid (not expired - 60 minutes)
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token reset tidak sah.']);
        }

        // Check if token is expired (60 minutes)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset telah tamat tempoh. Sila mohon semula.']);
        }

        // Verify token
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token reset tidak sah.']);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->kata_laluan = Hash::make($request->kata_laluan);
        $user->save();

        // Delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Send confirmation email
        try {
            Mail::send('emails.password_changed', ['user' => $user], function ($message) use ($request) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($request->email);
                $message->subject('[eBorang JDTM] Kata Laluan Telah Dikemaskini');
            });
            Log::info('Password changed confirmation email sent', ['email' => $request->email]);
        } catch (\Exception $e) {
            Log::error('Failed to send password changed confirmation email', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
        }

        return redirect('/login')->with('status', 'Kata laluan anda telah berjaya dikemaskini! Sila log masuk.');
    }

    /**
     * Send verification email (helper method)
     */
    private function sendVerificationEmail($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        // Generate verification token
        $token = Str::random(64);

        // Store token in email_verifications table
        DB::table('email_verifications')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Generate verification link
        $verificationLink = url('/verify-email/' . $token . '?email=' . urlencode($email));

        try {
            Mail::send('emails.verify_email', [
                'user' => $user,
                'verificationLink' => $verificationLink
            ], function ($message) use ($email) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($email);
                $message->subject('Verifikasi Email - eBorang JDTM');
            });

            Log::info('Verifikasi emel telah berjaya dihantar', ['email' => $email]);
            return true;
        } catch (\Exception $e) {
            Log::error('Gagal menghantar verifikasi emel', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}