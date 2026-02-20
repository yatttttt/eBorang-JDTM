<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    /**
     * Send verification email to user
     */
    public function sendVerificationEmail($email)
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
                $message->subject('[eBorang JDTM] Verifikasi Email');
            });

            Log::info('Verification email sent successfully', ['email' => $email]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send verification email', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Verify email with token
     */
    public function verifyEmail(Request $request, $token)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect('/login')->withErrors(['email' => 'Email tidak sah.']);
        }

        // Check if token exists
        $verification = DB::table('email_verifications')
            ->where('email', $email)
            ->first();

        if (!$verification) {
            return redirect('/login')->withErrors(['email' => 'Token verifikasi tidak sah.']);
        }

        // Check if token is expired (24 hours)
        if (Carbon::parse($verification->created_at)->addHours(24)->isPast()) {
            DB::table('email_verifications')->where('email', $email)->delete();
            return redirect('/login')->withErrors(['email' => 'Token verifikasi telah tamat tempoh. Sila log masuk semula untuk dapatkan email baharu.']);
        }

        // Verify token
        if (!Hash::check($token, $verification->token)) {
            return redirect('/login')->withErrors(['email' => 'Token verifikasi tidak sah.']);
        }

        // Update user email_verified_at
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            // Delete verification token
            DB::table('email_verifications')->where('email', $email)->delete();

            Log::info('Email verified successfully', ['email' => $email]);

            return redirect('/login')->with('status', 'Email anda telah berjaya disahkan! Sila log masuk.');
        }

        return redirect('/login')->withErrors(['email' => 'Pengguna tidak dijumpai.']);
    }

    /**
     * Show verification notice page
     */
    public function showVerificationNotice(Request $request)
    {
        $email = $request->session()->get('verification_email');

        if (!$email) {
            return redirect('/login');
        }

        return view('verify_email_notice', ['email' => $email]);
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if already verified
        if ($user->email_verified_at) {
            return back()->with('status', 'Email anda sudah disahkan. Sila log masuk.');
        }

        // Send verification email
        $sent = $this->sendVerificationEmail($request->email);

        if ($sent) {
            return back()->with('status', 'Email verifikasi telah dihantar semula! Sila semak inbox anda.');
        } else {
            return back()->withErrors(['email' => 'Gagal menghantar email. Sila cuba lagi.']);
        }
    }
}