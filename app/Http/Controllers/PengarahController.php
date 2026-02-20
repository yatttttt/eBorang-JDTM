<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\LogAktiviti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class PengarahController extends Controller
{
    /**
     * Display Pengarah dashboard with statistics
     */
    public function dashboard()
    {
        try {
            // Get statistics from database
            $lulus = Permohonan::where('status_pengarah', 'lulus')->count();
            $ditolak = Permohonan::where('status_pengarah', 'tolak')->count();
            $kiv = Permohonan::where('status_pengarah', 'KIV')->count();
            $total = Permohonan::count();

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

            return view('pengarah.pengarah', $data);
            
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

            return view('pengarah.pengarah', $data);
        }
    }

    /**
     * Alternative optimized method using single query
     */
    public function dashboardOptimized()
    {
        try {
            $stats = Permohonan::selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status_pengarah = "Diluluskan" THEN 1 ELSE 0 END) as lulus,
                SUM(CASE WHEN status_pengarah = "Ditolak" THEN 1 ELSE 0 END) as ditolak,
                SUM(CASE WHEN status_pengarah = "KIV" THEN 1 ELSE 0 END) as kiv
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

            return view('pengarah.pengarah', $data);
            
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

            return view('pengarah.pengarah', $data);
        }
    }

    /**
     * Display all applications for pengarah review
     */
    public function senaraiPermohonan(Request $request)
    {
        try {
            // Base query: Show pending or rejected/KIV applications
            $query = Permohonan::with('ulasans')
                ->where(function($q) {
                    $q->whereNull('status_pengarah')
                    ->orWhereIn('status_pengarah', ['tolak', 'KIV']);
                });
            
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
                    $query->whereNull('status_pengarah');
                } elseif ($request->status === 'kiv') {
                    $query->where('status_pengarah', 'KIV');
                } elseif ($request->status === 'ditolak') {
                    $query->where('status_pengarah', 'tolak');
                }
            }
            
            // Get paginated results with search/status preserved 
            $permohonans = $query
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->appends($request->only('search', 'status')); 
            
            // Calculate statistics - Only for pending/rejected/KIV
            $totalPermohonan = Permohonan::where(function($q) {
                    $q->whereNull('status_pengarah')
                    ->orWhereIn('status_pengarah', ['tolak', 'KIV']);
                })->count();
            
            $kiv = Permohonan::where('status_pengarah', 'KIV')->count();
            $ditolak = Permohonan::where('status_pengarah', 'tolak')->count();
            $pending = Permohonan::whereNull('status_pengarah')->count();
            
            return view('pengarah.senarai_permohonan', compact(
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
            return view('pengarah.senarai_permohonan_view', compact('permohonan'));
        } catch (\Exception $e) {
            Log::error('Error showing permohonan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }

    /**
     * Update application status by Pengarah
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            $validated = $request->validate([
                'status_pengarah' => 'required|in:Diluluskan,Ditolak,KIV',
                'ulasan_pengarah' => 'required|string|max:1000'
            ], [
                'status_pengarah.required' => 'Sila pilih status permohonan.',
                'status_pengarah.in' => 'Status tidak sah.',
                'ulasan_pengarah.required' => 'Ulasan adalah wajib.',
                'ulasan_pengarah.max' => 'Ulasan tidak boleh melebihi 1000 aksara.'
            ]);

            // Update Pengarah's review
            $permohonan->status_pengarah = $validated['status_pengarah'];
            $permohonan->ulasan_pengarah = $validated['ulasan_pengarah'];
            $permohonan->tarikh_ulasan_pengarah = now();
            $permohonan->ulasan_pengarah_by = Auth::id();

            // Update overall application status based on Pengarah's decision
            if ($validated['status_pengarah'] === 'Diluluskan') {
                $permohonan->status_permohonan = 'Selesai';
            } elseif ($validated['status_pengarah'] === 'Ditolak') {
                $permohonan->status_permohonan = 'Ditolak';
            } elseif ($validated['status_pengarah'] === 'KIV') {
                $permohonan->status_permohonan = 'KIV';
            }

            $permohonan->save();

            // Log the activity
            LogAktiviti::create([
                'id_user' => Auth::id(),
                'tindakan' => "Kemaskini status permohonan ID {$permohonan->id_permohonan} kepada '{$validated['status_pengarah']}' dengan ulasan: " . substr($validated['ulasan_pengarah'], 0, 50) . "..."
            ]);

            Log::info('Pengarah updated status', [
                'permohonan_id' => $id,
                'status' => $validated['status_pengarah'],
                'pengarah' => auth()->user()->nama ?? 'Unknown',
                'pengarah_id' => Auth::id() 
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
     * Display application history (reviewed by Pengarah)
     */
    public function senaraiPermohonanLama(Request $request)
    {
        try {
            // Base query: applications that Pengarah has APPROVED
            $query = Permohonan::where('status_pengarah', 'lulus')
                ->whereNotNull('tarikh_ulasan_pengarah');

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

            // ✅ COUNT SEBELUM PAGINATE (Count filtered results)
            $total = $query->count();

            // Get paginated results with search preserved
            $permohonans = $query
                ->with('ulasans')
                ->orderBy('tarikh_ulasan_pengarah', 'desc')
                ->paginate(10)
                ->appends($request->only('search'));
            
            // Optional: Count ALL approved (for reference)
            $totalAll = Permohonan::where('status_pengarah', 'lulus')
                ->whereNotNull('tarikh_ulasan_pengarah')
                ->count();
            
            return view('pengarah.senarai_permohonan_lama', compact('permohonans', 'total', 'totalAll'));

        } catch (\Exception $e) {
            Log::error('Error fetching old applications: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat senarai permohonan lama.');
        }
    }

    /**
     * Download application file
     */
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
     * Show review form for specific application
     */
    public function showReviewForm($id)
    {
        try {
            $permohonan = Permohonan::with('ulasans')->findOrFail($id);
            return view('pengarah.review_permohonan', compact('permohonan'));
        } catch (\Exception $e) {
            Log::error('Error showing review form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }

    /**
     * Show the form for editing the specified application (Pengarah version)
     */
    public function edit($id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            return view('pengarah.senarai_permohonan_edit', compact('permohonan'));
        } catch (\Exception $e) {
            Log::error('Error showing edit form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }

    /**
     * Update the specified application with pengarah approval (Pengarah version)
     */
    public function update(Request $request, $id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);

            // Only validate Pengarah decision fields
            $validated = $request->validate([
                'status_pengarah' => 'required|in:Lulus,KIV,Tolak',
                'ulasan_pengarah' => 'nullable|string|max:1000',
            ], [
                'status_pengarah.required' => 'Sila pilih status keputusan.',
                'status_pengarah.in' => 'Status tidak sah.',
                'ulasan_pengarah.max' => 'Ulasan tidak boleh melebihi 1000 aksara.'
            ]);

            // Update Pengarah's decision
            $permohonan->status_pengarah = $validated['status_pengarah'];
            $permohonan->ulasan_pengarah = $validated['ulasan_pengarah'] ?? null;
            $permohonan->ulasan_pengarah_by = Auth::id();

            // Set timestamp to current time when decision is made
            $permohonan->tarikh_ulasan_pengarah = now();
            
            // Update overall status based on pengarah decision
            if ($validated['status_pengarah'] === 'Lulus') {
                $permohonan->status_permohonan = 'Dalam Proses';
            } elseif ($validated['status_pengarah'] === 'KIV') {
                $permohonan->status_permohonan = 'Dalam Proses';
            } elseif ($validated['status_pengarah'] === 'Tolak') {
                $permohonan->status_permohonan = 'Dalam Proses';
            }

            // Save the record
            $permohonan->save();

            // Log the activity
            LogAktiviti::create([
                'id_user' => Auth::id(),
                'tindakan' => "Kemaskini status permohonan ID {$permohonan->id_permohonan} kepada '{$validated['status_pengarah']}'" . ($validated['ulasan_pengarah'] ? " dengan ulasan: " . substr($validated['ulasan_pengarah'], 0, 50) . "..." : "")
            ]);

            // ✉️ Smart workflow notification
            NotificationHelper::handleWorkflowNotification(
                $permohonan,
                auth()->user(),
                'pengarah',
                $validated['status_pengarah'],
                $validated['ulasan_pengarah'] ?? null
            );

            // Log the update
            Log::info('Pengarah updated permohonan', [
                'permohonan_id' => $id,
                'updated_by' => auth()->user()->nama ?? 'Unknown',
                'pengarah_id' => Auth::id(),
                'pengarah_status' => $validated['status_pengarah'],
                'timestamp' => $permohonan->tarikh_ulasan_pengarah,
                'email_sent' => true
            ]);

            return redirect()->route('pengarah.senarai-permohonan')->with('success', 'Keputusan berjaya disimpan dan notifikasi email telah dihantar!');


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
}