<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\LogAktiviti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class PegawaiController extends Controller
{
    /**
     * Display pegawai dashboard with statistics
     */
    public function dashboard()
    {
        try {
            // Get statistics from database - only permohonan approved by Pengarah
            $lulus = Permohonan::where('status_pengarah', 'lulus')
                            ->where('status_pegawai', 'lulus')
                            ->count();
            $ditolak = Permohonan::where('status_pengarah', 'lulus')
                                ->where('status_pegawai', 'tolak')
                                ->count();
            $kiv = Permohonan::where('status_pengarah', 'lulus')
                            ->where('status_pegawai', 'KIV')
                            ->count();
            $total = Permohonan::where('status_pengarah', 'lulus')->count();

            // Prepare data for JavaScript chart
            $permohonanData = [
                'total' => $total,
                'lulus' => $lulus,
                'tolak' => $ditolak,
                'kiv' => $kiv
            ];

            // Prepare data for view
            $data = [
                'lulus' => $lulus,
                'tolak' => $ditolak,
                'kiv' => $kiv,
                'total' => $total,
                'permohonanData' => $permohonanData
            ];

            return view('pegawai.pegawai', $data);
            
        } catch (\Exception $e) {
            // Handle any database errors
            $permohonanData = [
                'total' => 0,
                'lulus' => 0,
                'tolak' => 0,
                'kiv' => 0
            ];

            $data = [
                'lulus' => 0,
                'tolak' => 0,
                'kiv' => 0,
                'total' => 0,
                'permohonanData' => $permohonanData,
                'error' => 'Unable to fetch data: ' . $e->getMessage()
            ];

            return view('pegawai.pegawai', $data);
        }
    }

    /**
     * Alternative optimized method using single query
     */
    public function dashboardOptimized()
    {
        try {
            $stats = Permohonan::where('status_pengarah', 'lulus')
                ->selectRaw('
                    COUNT(*) as total,
                    SUM(CASE WHEN status_pegawai = "lulus" THEN 1 ELSE 0 END) as lulus,
                    SUM(CASE WHEN status_pegawai = "tolak" THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN status_pegawai = "KIV" THEN 1 ELSE 0 END) as kiv
                ')->first();

            // Prepare data for JavaScript chart
            $permohonanData = [
                'total' => $stats->total ?? 0,
                'lulus' => $stats->lulus ?? 0,
                'ditolak' => $stats->ditolak ?? 0,
                'kiv' => $stats->kiv ?? 0
            ];

            $data = [
                'lulus' => $stats->lulus ?? 0,
                'ditolak' => $stats->ditolak ?? 0,
                'kiv' => $stats->kiv ?? 0,
                'total' => $stats->total ?? 0,
                'permohonanData' => $permohonanData
            ];

            return view('pegawai.pegawai', $data);
            
        } catch (\Exception $e) {
            $permohonanData = [
                'total' => 0,
                'lulus' => 0,
                'ditolak' => 0,
                'kiv' => 0
            ];

            $data = [
                'lulus' => 0,
                'ditolak' => 0,
                'kiv' => 0,
                'total' => 0,
                'permohonanData' => $permohonanData,
                'error' => 'Unable to fetch data: ' . $e->getMessage()
            ];

            return view('pegawai.pegawai', $data);
        }
    }

    /**
     * Display all applications for pegawai review
     */
    public function senaraiPermohonan(Request $request)
    {
        try {
            $query = Permohonan::with('ulasans')
                ->where('status_pengarah', 'lulus')
                ->where(function($q) {
                    $q->whereNull('status_pegawai')
                    ->orWhereIn('status_pegawai', ['tolak', 'KIV']);
                });
            
            // Search functionality - CASE INSENSITIVE
            if ($request->filled('search')) {
                $search = strtolower($request->search);
                
                $query->where(function($q) use ($search) {
                    $q->whereRaw('LOWER(nama_pemohon) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(no_kawalan) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(no_kp) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(id_permohonan) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(kategori) LIKE ?', ["%{$search}%"]); 
                });
            }
            
            // Status filter
            if ($request->filled('status')) {
                if ($request->status === 'pending') {
                    $query->whereNull('status_pegawai');
                } elseif ($request->status === 'kiv') {
                    $query->where('status_pegawai', 'KIV');
                } elseif ($request->status === 'ditolak') {
                    $query->where('status_pegawai', 'tolak');
                }
            }
            
            // Get paginated results with search parameter preserved
            $permohonans = $query
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->appends($request->only('search', 'status'));
            
            // Calculate statistics
            $totalPermohonan = Permohonan::where('status_pengarah', 'lulus')
                ->where(function($q) {
                    $q->whereNull('status_pegawai')
                    ->orWhereIn('status_pegawai', ['tolak', 'KIV']);
                })
                ->count();
            
            $kiv = Permohonan::where('status_pengarah', 'lulus')
                ->where('status_pegawai', 'KIV')
                ->count();
            
            $ditolak = Permohonan::where('status_pengarah', 'lulus')
                ->where('status_pegawai', 'tolak')
                ->count();
            
            $pending = Permohonan::where('status_pengarah', 'lulus')
                ->whereNull('status_pegawai')
                ->count();
            
            return view('pegawai.senarai_permohonan', compact(
                'permohonans', 
                'totalPermohonan', 
                'kiv', 
                'ditolak',
                'pending'
            ));

        } catch (\Exception $e) {
            Log::error('Error fetching permohonan list: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat senarai permohonan.');
        }
    }

    /**
     * Display the specified application
     */
    public function show($id)
    {
        try {
            $permohonan = Permohonan::with('ulasans')->findOrFail($id);
            return view('pegawai.senarai_permohonan_view', compact('permohonan'));
        } catch (\Exception $e) {
            Log::error('Error showing permohonan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }

    /**
     * Update application status by pegawai
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            $validated = $request->validate([
                'status_pegawai' => 'required|in:Diluluskan,Ditolak,KIV',
                'ulasan_pegawai' => 'required|string|max:1000'
            ], [
                'status_pegawai.required' => 'Sila pilih status permohonan.',
                'status_pegawai.in' => 'Status tidak sah.',
                'ulasan_pegawai.required' => 'Ulasan adalah wajib.',
                'ulasan_pegawai.max' => 'Ulasan tidak boleh melebihi 1000 aksara.'
            ]);

            // Update pegawai's review
            $permohonan->status_pegawai = $validated['status_pegawai'];
            $permohonan->ulasan_pegawai = $validated['ulasan_pegawai'];
            $permohonan->tarikh_ulasan_pegawai = now();
            $permohonan->ulasan_pegawai_by = Auth::id();

            // Update overall application status based on pegawai's decision
            if ($validated['status_pegawai'] === 'Diluluskan') {
                $permohonan->status_permohonan = 'Selesai';
            } elseif ($validated['status_pegawai'] === 'Ditolak') {
                $permohonan->status_permohonan = 'Ditolak';
            } elseif ($validated['status_pegawai'] === 'KIV') {
                $permohonan->status_permohonan = 'KIV';
            }

            $permohonan->save();

            // Log the activity
            LogAktiviti::create([
                'id_user' => Auth::id(),
                'tindakan' => "Kemaskini status permohonan ID {$permohonan->id_permohonan} kepada '{$validated['status_pegawai']}' dengan ulasan: " . substr($validated['ulasan_pegawai'], 0, 50) . "..."
            ]);

            Log::info('pegawai updated status', [
                'permohonan_id' => $id,
                'status' => $validated['status_pegawai'],
                'pegawai' => auth()->user()->nama ?? 'Unknown'
            ]);

            return redirect()->back()->with('success', 'Status permohonan berjaya dikemaskini.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengemaskini status: ' . $e->getMessage());
        }
    }

     /**
     * Show the form for editing the specified application (pegawai version)
     */
    public function edit($id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            // Get list of Pentadbir Sistem users
            $pentadbirList = \App\Models\User::where('peranan', 'pentadbir_sistem')
                ->orderBy('nama', 'asc')
                ->get();
            
            return view('pegawai.senarai_permohonan_edit', compact('permohonan', 'pentadbirList'));
        } catch (\Exception $e) {
            Log::error('Error showing edit form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }

    /**
     * Update the specified application in storage (pegawai version)
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('=== Update Permohonan Start ===');
            Log::info('Request Data:', $request->all());
            
            $permohonan = Permohonan::findOrFail($id);

            // Validation rules
            $rules = [
                'status_pegawai' => 'required|in:Lulus,KIV,Tolak',
                'ulasan_pegawai' => 'nullable|string|max:1000',
            ];

            // If status is Lulus, pentadbir is REQUIRED (can be multiple)
            if ($request->status_pegawai === 'Lulus') {
                $rules['ulasan_pentadbir_sistem_by'] = 'required|array|min:1';
                $rules['ulasan_pentadbir_sistem_by.*'] = 'required|exists:users,id_user';
            }

            $validated = $request->validate($rules, [
                'status_pegawai.required' => 'Sila pilih status keputusan.',
                'status_pegawai.in' => 'Status tidak sah.',
                'ulasan_pegawai.max' => 'Ulasan tidak boleh melebihi 1000 aksara.',
                'ulasan_pentadbir_sistem_by.required' => 'Sila pilih sekurang-kurangnya seorang Pentadbir Sistem untuk permohonan yang diluluskan.',
                'ulasan_pentadbir_sistem_by.array' => 'Format Pentadbir Sistem tidak sah.',
                'ulasan_pentadbir_sistem_by.min' => 'Sila pilih sekurang-kurangnya seorang Pentadbir Sistem.',
                'ulasan_pentadbir_sistem_by.*.exists' => 'Salah satu Pentadbir Sistem yang dipilih tidak wujud.',
            ]);

            Log::info('Validation Passed');
            Log::info('Validated Data:', $validated);

            // Update pegawai's decision
            $permohonan->status_pegawai = $validated['status_pegawai'];
            $permohonan->ulasan_pegawai = $validated['ulasan_pegawai'] ?? null;
            $permohonan->ulasan_pegawai_by = Auth::id();
            $permohonan->tarikh_ulasan_pegawai = now();

            if ($validated['status_pegawai'] === 'Lulus') {
                // Store multiple pentadbir IDs - pass array; model cast akan json_encode secara automatik
                if (!$permohonan->tarikh_ulasan_pentadbir_sistem) {
                    $permohonan->ulasan_pentadbir_sistem_by = $validated['ulasan_pentadbir_sistem_by'];
                }
                $permohonan->status_permohonan = 'Dalam Proses';
            } else {
                // Clear pentadbir assignment for KIV/Tolak
                $permohonan->ulasan_pentadbir_sistem_by = null;
                $permohonan->status_permohonan = 'Dalam Proses';
            }

            $permohonan->save();

            // Log the activity
            LogAktiviti::create([
                'id_user' => Auth::id(),
                'tindakan' => "Kemaskini status permohonan ID {$permohonan->id_permohonan} kepada '{$validated['status_pegawai']}'" . ($validated['ulasan_pegawai'] ? " dengan ulasan: " . substr($validated['ulasan_pegawai'], 0, 50) . "..." : "")
            ]);

            try {
                Log::info('Sending status update to admins', [
                    'permohonan_id' => $id,
                    'status' => $validated['status_pegawai']
                ]);

                NotificationHelper::notifyAdmins(
                    $permohonan,
                    auth()->user(),
                    'pegawai',
                    $validated['status_pegawai'],
                    $validated['ulasan_pegawai'] ?? null
                );

                Log::info('Admin notified successfully', [
                    'permohonan_id' => $id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to notify admins', [
                    'permohonan_id' => $id,
                    'error' => $e->getMessage()
                ]);
            }

            // Send email to all assigned pentadbir
            if ($validated['status_pegawai'] === 'Lulus' && !empty($validated['ulasan_pentadbir_sistem_by'])) {
                try {
                    foreach ($validated['ulasan_pentadbir_sistem_by'] as $pentadbir_id) {
                        $pentadbir = \App\Models\User::find($pentadbir_id);
                        
                        if ($pentadbir) {
                            NotificationHelper::notifySpecificUser(
                                $pentadbir,
                                $permohonan,
                                'pegawai_approved',
                                auth()->user()
                            );

                            Log::info('Pentadbir Sistem notified', [
                                'permohonan_id' => $id,
                                'pentadbir_id' => $pentadbir->id_user,
                                'pentadbir_email' => $pentadbir->email
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to notify pentadbir: ' . $e->getMessage());
                }
            }

            Log::info('Pegawai updated permohonan', [
                'permohonan_id' => $id,
                'pegawai_status' => $validated['status_pegawai'],
                'pentadbir_assigned' => $permohonan->ulasan_pentadbir_sistem_by ?? 'None',
            ]);

            return redirect()->route('pegawai.senarai-permohonan')
                ->with('success', 'Keputusan berjaya disimpan dan notifikasi email telah dihantar!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating permohonan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terdapat ralat semasa menyimpan keputusan.')
                ->withInput();
        }
    }

    /**
     * Submit review for application
     */
    public function submitReview(Request $request, $id)
    {
        return $this->updateStatus($request, $id);
    }

    public function downloadFile($id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            if (!$permohonan->fail_borang) {
                return redirect()->back()->with('error', 'Fail tidak dijumpai.');
            }

            $filePath = storage_path('app/public/' . $permohonan->fail_borang);
            
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'Fail tidak dijumpai di server.');
            }

            return response()->download($filePath);

        } catch (\Exception $e) {
            Log::error('Error downloading file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat turun fail: ' . $e->getMessage());
        }
    }

    /**
     * Display application history (reviewed by pegawai)
     */
    public function senaraiPermohonanLama(Request $request)
    {
        try {
            // Base query: applications that pegawai has APPROVED
            $query = Permohonan::where('status_pegawai', 'lulus')
                ->whereNotNull('tarikh_ulasan_pegawai');

            // Search functionality - CASE INSENSITIVE
            if ($request->filled('search')) {
                $search = strtolower($request->search); 

                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(nama_pemohon) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(no_kawalan) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(no_kp) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(id_permohonan) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(kategori) LIKE ?', ["%{$search}%"]);
                });
            }

            $total = $query->count();

            // Get paginated results with search preserved
            $permohonans = $query
                ->with('ulasans')
                ->orderBy('tarikh_ulasan_pegawai', 'desc')
                ->paginate(10)
                ->appends($request->only('search'));
            
            // Optional: Count ALL approved (for reference)
            $totalAll = Permohonan::where('status_pegawai', 'lulus')
                ->whereNotNull('tarikh_ulasan_pegawai')
                ->count();
            
            return view('pegawai.senarai_permohonan_lama', compact('permohonans', 'total', 'totalAll'));

        } catch (\Exception $e) {
            Log::error('Error fetching old applications: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat senarai permohonan lama.');
        }
    }
}