<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Constructor to apply middleware for admin only access
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->peranan !== 'admin') {
                abort(403, 'Akses ditolak. Hanya admin yang dibenarkan.');
            }
            return $next($request);
        });
    }

    /**
     * Display listing with case-insensitive search (sama seperti senaraiPermohonan)
     */
    public function index(Request $request)
    {
        try {
            $query = User::query();
            
            // Case-insensitive search - SAMA seperti dalam AdminController::senaraiPermohonan
            if ($request->filled('search')) {
                $search = strtolower($request->search);
                
                $query->where(function($q) use ($search) {
                    $q->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"])
                      ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                      ->orWhereRaw('LOWER(peranan) LIKE ?', ["%{$search}%"])
                      ->orWhereRaw('LOWER(id_user) LIKE ?', ["%{$search}%"]);
                });
            }
            
            // Filter by role if provided
            if ($request->filled('peranan')) {
                $query->where('peranan', $request->peranan);
            }
            
            // Count filtered results BEFORE pagination
            $total = $query->count();
            
            $users = $query
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->appends($request->only('search', 'peranan'));
            
            // Total count of ALL users (without filters)
            $totalAll = User::count();
            
            return view('admin.pengurusan_pengguna', compact('users', 'total', 'totalAll'));
            
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal memuat senarai pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.tambah_pengguna');
    }

    /**
     * Store with case-insensitive email duplicate check
     */
    public function store(Request $request)
    {
        try {
            // Case-insensitive unique email validation
            $request->validate([
                'nama' => 'required|string|max:100',
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    // Case-insensitive unique check
                    Rule::unique('users', 'email')->where(function ($query) use ($request) {
                        return $query->whereRaw('LOWER(email) = ?', [strtolower($request->email)]);
                    })
                ],
                'kata_laluan' => 'required|string|min:6|max:100|confirmed',
                'peranan' => 'required|in:admin,pengarah,pegawai,pentadbir_sistem',
            ], [
                'nama.required' => 'Nama adalah wajib.',
                'nama.max' => 'Nama tidak boleh melebihi 100 aksara.',
                'email.required' => 'Email adalah wajib.',
                'email.email' => 'Format email tidak sah.',
                'email.unique' => 'Email ini telah digunakan.',
                'email.max' => 'Email tidak boleh melebihi 100 aksara.',
                'kata_laluan.required' => 'Kata laluan adalah wajib.',
                'kata_laluan.min' => 'Kata laluan mestilah sekurang-kurangnya 6 aksara.',
                'kata_laluan.max' => 'Kata laluan tidak boleh melebihi 100 aksara.',
                'kata_laluan.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
                'peranan.required' => 'Peranan adalah wajib.',
                'peranan.in' => 'Peranan yang dipilih tidak sah.',
            ]);

            // Store email as entered (maintain original case)
            User::create([
                'nama' => $request->nama,
                'email' => $request->email, // Keep original case
                'kata_laluan' => Hash::make($request->kata_laluan),
                'peranan' => $request->peranan,
            ]);

            Log::info('New user created', [
                'nama' => $request->nama,
                'email' => $request->email,
                'peranan' => $request->peranan
            ]);

            return redirect()->route('pengurusan.pengguna')->with('success', 'Pengguna baru berjaya ditambah.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in store user', [
                'errors' => $e->errors(),
                'input' => $request->except(['kata_laluan', 'kata_laluan_confirmation'])
            ]);
            
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->with('error', 'Ralat berlaku semasa menambah pengguna: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error fetching user for edit: ' . $e->getMessage());
            return redirect()->route('pengurusan.pengguna')
                ->with('error', 'Pengguna tidak dijumpai.');
        }
    }

    /**
     * Update with case-insensitive email duplicate check
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Case-insensitive unique email validation (excluding current user)
            $request->validate([
                'nama' => 'required|string|max:100',
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    Rule::unique('users', 'email')
                        ->ignore($user->id_user, 'id_user')
                        ->where(function ($query) use ($request) {
                            return $query->whereRaw('LOWER(email) = ?', [strtolower($request->email)]);
                        })
                ],
                'kata_laluan' => 'nullable|string|min:6|max:100|confirmed',
                'peranan' => 'required|in:admin,pengarah,pegawai,pentadbir_sistem',
            ], [
                'nama.required' => 'Nama adalah wajib.',
                'nama.max' => 'Nama tidak boleh melebihi 100 aksara.',
                'email.required' => 'Email adalah wajib.',
                'email.email' => 'Format email tidak sah.',
                'email.unique' => 'Email ini telah digunakan.',
                'email.max' => 'Email tidak boleh melebihi 100 aksara.',
                'kata_laluan.min' => 'Kata laluan mestilah sekurang-kurangnya 6 aksara.',
                'kata_laluan.max' => 'Kata laluan tidak boleh melebihi 100 aksara.',
                'kata_laluan.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
                'peranan.required' => 'Peranan adalah wajib.',
                'peranan.in' => 'Peranan yang dipilih tidak sah.',
            ]);

            $updateData = [
                'nama' => $request->nama,
                'email' => $request->email, // Keep original case
                'peranan' => $request->peranan,
            ];

            // Only update password if provided
            if ($request->filled('kata_laluan')) {
                $updateData['kata_laluan'] = Hash::make($request->kata_laluan);
            }

            $user->update($updateData);

            Log::info('User updated', [
                'id' => $user->id_user,
                'nama' => $user->nama,
                'email' => $user->email
            ]);

            return redirect()->route('pengurusan.pengguna')->with('success', 'Pengguna berjaya dikemaskini.');
            
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ralat berlaku semasa mengemaskini pengguna: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting your own account
            if ($user->id_user == auth()->user()->id_user) {
                return redirect()->route('pengurusan.pengguna')
                    ->with('error', 'Anda tidak boleh memadamkan akaun anda sendiri.');
            }
            
            // Delete profile picture if exists
            if ($user->gambar_profil && Storage::exists('public/' . $user->gambar_profil)) {
                Storage::delete('public/' . $user->gambar_profil);
            }
            
            $userName = $user->nama;
            $user->delete();
            
            Log::info('User deleted', [
                'id' => $id,
                'nama' => $userName
            ]);
            
            return redirect()->route('pengurusan.pengguna')
                ->with('success', 'Pengguna berjaya dipadamkan.');
                
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memadam pengguna: ' . $e->getMessage());
        }
    }
}