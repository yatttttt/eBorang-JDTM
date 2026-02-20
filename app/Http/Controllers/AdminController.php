<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\User;
use App\Models\LogAktiviti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Mail;  
use App\Mail\PermohonanBerjayaNotification;  

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with permohonan statistics
     */
    public function dashboard()
    {
        try {
            $lulus = Permohonan::where('status_permohonan', Permohonan::STATUS_SELESAI)->count();

            // Count all that are marked "Ditolak" (using correct constant)
            $ditolak = Permohonan::where(function ($query) {
                $query->where('status_pengarah', Permohonan::STATUS_TOLAK)
                    ->orWhere('status_pegawai', Permohonan::STATUS_TOLAK)
                    ->orWhere('status_pentadbir_sistem', Permohonan::STATUS_TOLAK);
            })->count();

            // Count all that are marked "KIV" 
            $kiv = Permohonan::where(function ($query) {
                $query->where('status_pengarah', Permohonan::STATUS_KIV)
                    ->orWhere('status_pegawai', Permohonan::STATUS_KIV)
                    ->orWhere('status_pentadbir_sistem', Permohonan::STATUS_KIV);
            })->count();

            // Total count
            $total = Permohonan::count();

            // Prepare data for JavaScript chart
            $permohonanData = [
                'total' => $total,
                'lulus' => $lulus,
                'ditolak' => $ditolak,
                'kiv' => $kiv
            ];

            // Prepare data for view
            $data = [
                'lulus' => $lulus,
                'ditolak' => $ditolak,
                'kiv' => $kiv,
                'total' => $total,
                'permohonanData' => $permohonanData
            ];

            return view('admin.admin', $data);
            
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

            return view('admin.admin', $data);
        }
    }

    public function dashboardOptimized()
    {
        return $this->dashboard(); 
    }

    /**
    * Display the upload application form
    */
    public function showUploadForm()
    {
        return view('admin.upload_permohonan');
    }

    /**
    * Store a new application
    */
    public function storePermohonan(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_pemohon' => 'required|string|max:255',
                'no_kp' => 'required|string|max:20|unique:permohonans,no_kp',
                'jawatan' => 'nullable|string|max:255',
                'jabatan' => 'nullable|string|max:255',
                'kategori' => 'required|array|min:1',          
                'kategori.*' => 'required|string|max:255',     
                'subkategori' => 'nullable|array',          
                'subkategori.*' => 'nullable|string|max:255',   
                'fail_borang' => 'required|file|mimes:pdf,doc,docx|max:10240'
            ], [
                'nama_pemohon.required' => 'Nama pemohon diperlukan.',
                'no_kp.required' => 'No. Kad Pengenalan diperlukan.',
                'no_kp.unique' => 'No. Kad Pengenalan ini telah wujud dalam sistem.',
                'kategori.required' => 'Sila pilih sekurang-kurangnya satu kategori.',  
                'kategori.min' => 'Sila pilih sekurang-kurangnya satu kategori.',       
                'kategori.*.required' => 'Kategori tidak boleh kosong.',                
                'fail_borang.required' => 'Fail borang diperlukan.',
                'fail_borang.mimes' => 'Fail borang mestilah dalam format PDF, DOC, atau DOCX.',
                'fail_borang.max' => 'Saiz fail borang tidak boleh melebihi 10MB.',
            ]);

            // Handle file upload
            $fileName = null;
            if ($request->hasFile('fail_borang')) {
                $file = $request->file('fail_borang');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/permohonan', $fileName);
            }

            $kategoriArray = array_values(array_filter(
                $request->input('kategori', []), 
                fn($value) => !empty($value)
            ));
            
            $subkategoriArray = array_values(array_filter(
                $request->input('subkategori', []), 
                fn($value) => !empty($value)
            ));

            // Create new permohonan record
            $permohonan = new Permohonan();
            $permohonan->nama_pemohon = $validatedData['nama_pemohon'];
            $permohonan->no_kp = $validatedData['no_kp'];
            $permohonan->jawatan = $validatedData['jawatan'] ?? null;
            $permohonan->jabatan = $validatedData['jabatan'] ?? null;
            
            // Store as arrays (will be auto-converted to JSON by Model casting)
            $permohonan->kategori = !empty($kategoriArray) ? $kategoriArray : null;
            $permohonan->subkategori = !empty($subkategoriArray) ? $subkategoriArray : null;
            
            $permohonan->fail_borang = $fileName;
                
            // Set initial stage statuses to NULL
            $permohonan->status_pengarah = null;
            $permohonan->status_pegawai = null;
            $permohonan->status_pentadbir_sistem = null;
            $permohonan->tarikh_hantar = now();
            
            // Observer will automatically call determineOverallStatus() in "creating" event
            $permohonan->save();
            
            // Log for debugging
            Log::info('Permohonan created successfully', [
                'id' => $permohonan->id_permohonan,
                'status' => $permohonan->status_permohonan,
                'kategori' => $permohonan->kategori,
                'nama' => $permohonan->nama_pemohon
            ]);

            // ✉️ 【TAMBAH BARU】Email kepada Admin yang submit (Confirmation)
            try {
                $adminEmail = auth()->user()->email;
                
                Mail::to($adminEmail)->send(new PermohonanBerjayaNotification($permohonan));
                
                // Send system notification (in-app notification)
                NotificationHelper::notifyAdminsApplicationSubmitted($permohonan, auth()->user());
                
                Log::info('Confirmation email sent to admin successfully', [
                    'permohonan_id' => $permohonan->id_permohonan,
                    'admin_email' => $adminEmail,
                    'admin_name' => auth()->user()->name ?? 'Unknown'
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send confirmation email to admin', [
                    'permohonan_id' => $permohonan->id_permohonan,
                    'admin_email' => auth()->user()->email ?? 'not found',
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Don't fail the entire request if email fails
            }
                
            // ✉️ Email kepada Pengarah untuk review (existing)
            try {
                NotificationHelper::notifyNextReviewer($permohonan, 'pengarah');
                
                Log::info('Pengarah notified successfully', [
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to notify Pengarah', [
                    'permohonan_id' => $permohonan->id_permohonan,
                    'error' => $e->getMessage()
                ]);
            }

            return redirect()->back()->with('success', 
                'Permohonan berjaya dihantar! Nombor rujukan: ' . $permohonan->id_permohonan . 
                '. Email pengesahan telah dihantar ke ' . auth()->user()->email
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            //Log validation errors
            Log::error('Validation error in storePermohonan', [
                'errors' => $e->errors(),
                'input' => $request->except(['fail_borang'])
            ]);
            
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Error storing permohonan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
                
            return redirect()->back()
                ->with('error', 'Terdapat masalah semasa menghantar permohonan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show single permohonan (for email notification links)
     */
    public function show($id)
    {
        try {
            $permohonan = Permohonan::with('ulasans')->findOrFail($id);
            
            // Senarai Pentadbir Sistem yang ditugaskan
            $assignedPentadbir = collect([]);
            $pentadbirIds = $permohonan->ulasan_pentadbir_sistem_by;

            if ($pentadbirIds !== null && $pentadbirIds !== '') {
                $ids = [];
                if (is_array($pentadbirIds)) {
                    $ids = array_values(array_filter(array_map('intval', $pentadbirIds)));
                } elseif (is_numeric($pentadbirIds)) {
                    $ids = [(int) $pentadbirIds];
                } else {
                    $decoded = json_decode($pentadbirIds, true);
                    if (is_array($decoded)) {
                        $ids = array_values(array_filter(array_map('intval', $decoded)));
                    }
                }
                
                if (!empty($ids)) {
                    $assignedPentadbir = User::whereIn('id_user', $ids)->get();
                }
            }

            return view('admin.senarai_permohonan_lama_view', compact('permohonan', 'assignedPentadbir'));
        } catch (\Exception $e) {
            Log::error('Error showing permohonan from email: ' . $e->getMessage());
            return redirect()->route('dashboard.admin')
                ->with('error', 'Permohonan tidak dijumpai.');
        }
    }
    
    /**
    * Display all applications for admin review
    */
    public function senaraiPermohonan(Request $request)
    {
        try {
            // Base query: Filter applications that are not completed
            $query = Permohonan::with('ulasans')
                ->where(function($q) {
                    $q->where('status_permohonan', '!=', Permohonan::STATUS_SELESAI)
                    ->orWhereNull('status_permohonan');
                });
            
            if ($request->filled('search')) {
                $search = strtolower($request->search);
                
                $query->where(function($q) use ($search) {
                    $q->whereRaw('LOWER(nama_pemohon) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(no_kawalan) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(no_kp) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(kategori) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(status_permohonan) LIKE ?', ["%{$search}%"]);
                });
            }
            
            // Status filter (dropdown/button filter)
            if ($request->filled('status')) {
                $query->where('status_permohonan', $request->status);
            }

            // Kategori filter
            if ($request->filled('kategori')) {
                $query->whereJsonContains('kategori', $request->kategori);
            }
            
            $permohonans = $query
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->appends($request->only('search', 'status', 'kategori'));
            
            // Update status untuk setiap permohonan
            foreach ($permohonans as $permohonan) {
                $permohonan->determineOverallStatus();
                $permohonan->save();
            }
            
            return view('admin.senarai_permohonan', compact('permohonans'));

        } catch (\Exception $e) {
            Log::error('Error fetching permohonan list: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal memuat senarai permohonan: ' . $e->getMessage());
        }
    }

    /**
     * Update status permohonan based on ulasan
     */
    private function updateStatusPermohonan($permohonan)
    {
        // Check jika ada ulasan yang KIV atau Tolak
        $adaKIV = $permohonan->ulasans()->where('status', 'KIV')->exists();
        $adaTolak = $permohonan->ulasans()->where('status', 'Ditolak')->exists();
        
        // Priority: Ditolak > KIV > Check Lulus
        if ($adaTolak) {
            if ($permohonan->status_permohonan !== 'Ditolak') {
                $permohonan->status_permohonan = 'Ditolak';
                $permohonan->save();
            }
            return;
        }
        
        if ($adaKIV) {
            if ($permohonan->status_permohonan !== 'KIV') {
                $permohonan->status_permohonan = 'KIV';
                $permohonan->save();
            }
            return;
        }
        
        // Jika tiada KIV atau Tolak, check jika semua Lulus
        $jumlahUlasan = $permohonan->ulasans()->count();
        $jumlahLulus = $permohonan->ulasans()->where('status', 'Lulus')->count();
        
        // Jika ada ulasan dan semua lulus
        if ($jumlahUlasan > 0 && $jumlahLulus === $jumlahUlasan) {
            if ($permohonan->status_permohonan !== 'Lulus') {
                $permohonan->status_permohonan = 'Lulus';
                $permohonan->save();
            }
        } 
        // Jika ada ulasan tapi belum semua lulus (masih ada yang pending)
        elseif ($jumlahUlasan > 0) {
            if ($permohonan->status_permohonan !== 'Dalam Proses') {
                $permohonan->status_permohonan = 'Dalam Proses';
                $permohonan->save();
            }
        }
    }

    /**
     * Display all completed applications.
     */
    public function senaraiPermohonanLama(Request $request)
    {
        try {
            // Base query: Applications with "Selesai" status
            $query = Permohonan::where('status_permohonan', 'Selesai')
                ->whereNotNull('tarikh_hantar');

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

            $permohonans = $query
                ->with('ulasans')
                ->orderBy('tarikh_hantar', 'desc')
                ->paginate(10)
                ->appends($request->only('search'));
            
            // Total count of all completed applications
            $totalAll = Permohonan::where('status_permohonan', 'Selesai')
                ->whereNotNull('tarikh_hantar')
                ->count();
            
            return view('admin.senarai_permohonan_lama', compact('permohonans', 'total', 'totalAll'));

        } catch (\Exception $e) {
            Log::error('Error fetching old applications: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat senarai permohonan lama.');
        }
    }

    /**
     * View single application details
     */
    public function viewPermohonanLama($id)
    {
        try {
            $permohonan = Permohonan::with('ulasans')->findOrFail($id);

            // Senarai Pentadbir Sistem yang ditugaskan
            $assignedPentadbir = collect([]);
            $pentadbirIds = $permohonan->ulasan_pentadbir_sistem_by;

            if ($pentadbirIds !== null && $pentadbirIds !== '') {
                $ids = [];
                if (is_array($pentadbirIds)) {
                    $ids = array_values(array_filter(array_map('intval', $pentadbirIds)));
                } elseif (is_numeric($pentadbirIds)) {
                    $ids = [(int) $pentadbirIds];
                } else {
                    $decoded = json_decode($pentadbirIds, true);
                    if (is_array($decoded)) {
                        $ids = array_values(array_filter(array_map('intval', $decoded)));
                    }
                }
                
                if (!empty($ids)) {
                    $assignedPentadbir = User::whereIn('id_user', $ids)->get();
                }
            }

            return view('admin.senarai_permohonan_lama_view', compact('permohonan', 'assignedPentadbir'));
        } catch (\Exception $e) {
            Log::error('Error viewing permohonan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }

    /**
    * Update application status (Admin/Pegawai)
    */
    public function updateStatus(Request $request, $id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
        
            // This setup is CORRECT and uses constants
            $allowedStatuses = [
                Permohonan::STATUS_DILULUSKAN,
                Permohonan::STATUS_DITOLAK,
                Permohonan::STATUS_KIV,
                'Pending',
            ];

            $request->validate([
                'status_pegawai' => 'required|in:' . implode(',', $allowedStatuses),
                'catatan_pegawai' => 'nullable|string|max:1000'
            ]);

            $permohonan->status_pegawai = $request->status_pegawai;
            $permohonan->catatan_pegawai = $request->catatan_pegawai;
            $permohonan->tarikh_tindakan = now();
            $permohonan->save(); // This triggers the Observer

            return redirect()->route('admin.senarai.permohonan')->with('success', 'Status permohonan berjaya dikemaskini.');
        } catch (\Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengemaskini status: ' . $e->getMessage());
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

            $filePath = storage_path('app/public/permohonan/' . $permohonan->fail_borang);
            
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'Fail tidak dijumpai di server.');
            }

            return response()->download($filePath);

        } catch (\Exception $e) {
            Log::error('Error downloading file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat turun fail: ' . $e->getMessage());
        }
    }

    /*
     * Delete permohonan lama
     */
    public function destroyPermohonanLama($id)
    {
        try {
            // Cari permohonan berdasarkan ID
            $permohonan = Permohonan::findOrFail($id);
            
            // Simpan nama pemohon untuk success message
            $namaPemohon = $permohonan->nama_pemohon;
            
            // Padam fail borang jika ada
            if ($permohonan->fail_borang) {
                $filePath = 'public/permohonan/' . $permohonan->fail_borang;
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
            
            // Padam permohonan dari database
            $permohonan->delete();
            
            // Log activity
            Log::info('Permohonan deleted', [
                'id' => $id,
                'nama' => $namaPemohon
            ]);
            
            // Redirect dengan success message
            return redirect()->route('admin.senarai_permohonan_lama')
                            ->with('success', "Permohonan atas nama {$namaPemohon} berjaya dipadam.");
                            
        } catch (\Exception $e) {
            Log::error('Error deleting permohonan: ' . $e->getMessage());
            
            // Redirect dengan error message
            return redirect()->route('admin.senarai_permohonan_lama')
                            ->with('error', 'Gagal memadam permohonan. Sila cuba lagi.');
        }
    }

    /**
     * Display all activity logs
     */
    public function logAktiviti(Request $request)
    {
        try {
            $query = LogAktiviti::with('user');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('tindakan', 'LIKE', "%{$search}%");
                });
            }

            // Type filter
            if ($request->has('type') && !empty($request->type)) {
                $type = $request->type;
                $query->where(function ($q) use ($type) {
                    switch ($type) {
                        case 'login':
                            $q->where('tindakan', 'LIKE', '%login%');
                            break;
                        case 'logout':
                            $q->where('tindakan', 'LIKE', '%logout%');
                            break;
                        case 'status':
                            $q->where('tindakan', 'LIKE', '%status%')
                              ->orWhere('tindakan', 'LIKE', '%Kemaskini%');
                            break;
                        case 'upload':
                            $q->where('tindakan', 'LIKE', '%Muat naik%')
                              ->orWhere('tindakan', 'LIKE', '%upload%');
                            break;
                    }
                });
            }

            // Order by latest first
            $logs = $query->orderBy('created_at', 'DESC')->paginate(10);

            return view('admin.log_aktiviti', compact('logs'));
        } catch (\Exception $e) {
            Log::error('Error loading activity logs: ' . $e->getMessage());
            return redirect()->route('dashboard.admin')
                            ->with('error', 'Gagal memuat log aktiviti: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint for AJAX log filtering
     */
    public function getLogAktiviti(Request $request)
    {
        try {
            $query = LogAktiviti::with('user');

            // Search functionality
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('tindakan', 'LIKE', "%{$search}%");
                });
            }

            // Type filter
            if ($request->has('type') && !empty($request->type)) {
                $type = $request->type;
                $query->where(function ($q) use ($type) {
                    switch ($type) {
                        case 'login':
                            $q->where('tindakan', 'LIKE', '%login%');
                            break;
                        case 'logout':
                            $q->where('tindakan', 'LIKE', '%logout%');
                            break;
                        case 'status':
                            $q->where('tindakan', 'LIKE', '%status%')
                              ->orWhere('tindakan', 'LIKE', '%Kemaskini%');
                            break;
                        case 'upload':
                            $q->where('tindakan', 'LIKE', '%Muat naik%')
                              ->orWhere('tindakan', 'LIKE', '%upload%');
                            break;
                    }
                });
            }

            // Order by latest first and paginate
            $logs = $query->orderBy('created_at', 'DESC')->paginate(10);

            // Build custom pagination HTML
            $paginationHtml = $this->buildCustomPagination($logs);

            // Return JSON response
            return response()->json([
                'success' => true,
                'html' => view('admin.partials.log_aktiviti_table', compact('logs'))->render(),
                'pagination' => $paginationHtml,
                'count' => $logs->total()
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading activity logs via AJAX: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat log aktiviti: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Build custom pagination HTML for AJAX response
     */
    private function buildCustomPagination($logs)
    {
        $html = '<div class="pagination-container">';
        $html .= '<div class="pagination-info">';
        $html .= 'Memaparkan ' . ($logs->firstItem() ?? 0) . ' hingga ' . ($logs->lastItem() ?? 0) . ' daripada ' . $logs->total() . ' log aktiviti';
        $html .= '</div>';
        
        $html .= '<div class="pagination-wrapper">';
        $html .= '<nav class="pagination-nav">';
        
        // Previous button
        if ($logs->onFirstPage()) {
            $html .= '<span class="pagination-btn pagination-btn-disabled">';
            $html .= '<i class="fas fa-chevron-left"></i>';
            $html .= '<span class="btn-text">Sebelum</span>';
            $html .= '</span>';
        } else {
            $html .= '<a href="' . $logs->previousPageUrl() . '" class="pagination-btn pagination-btn-prev" onclick="handlePaginationClick(event, \'' . $logs->previousPageUrl() . '\')">';
            $html .= '<i class="fas fa-chevron-left"></i>';
            $html .= '<span class="btn-text">Sebelum</span>';
            $html .= '</a>';
        }
        
        // Page numbers
        $html .= '<div class="pagination-numbers">';
        
        $start = max($logs->currentPage() - 2, 1);
        $end = min($start + 4, $logs->lastPage());
        $start = max($end - 4, 1);
        
        if ($start > 1) {
            $html .= '<a href="' . $logs->url(1) . '" class="pagination-number" onclick="handlePaginationClick(event, \'' . $logs->url(1) . '\')">1</a>';
            if ($start > 2) {
                $html .= '<span class="pagination-dots">...</span>';
            }
        }
        
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $logs->currentPage()) {
                $html .= '<span class="pagination-number active">' . $i . '</span>';
            } else {
                $html .= '<a href="' . $logs->url($i) . '" class="pagination-number" onclick="handlePaginationClick(event, \'' . $logs->url($i) . '\')">' . $i . '</a>';
            }
        }
        
        if ($end < $logs->lastPage()) {
            if ($end < $logs->lastPage() - 1) {
                $html .= '<span class="pagination-dots">...</span>';
            }
            $html .= '<a href="' . $logs->url($logs->lastPage()) . '" class="pagination-number" onclick="handlePaginationClick(event, \'' . $logs->url($logs->lastPage()) . '\')">' . $logs->lastPage() . '</a>';
        }
        
        $html .= '</div>';
        
        // Next button
        if ($logs->hasMorePages()) {
            $html .= '<a href="' . $logs->nextPageUrl() . '" class="pagination-btn pagination-btn-next" onclick="handlePaginationClick(event, \'' . $logs->nextPageUrl() . '\')">';
            $html .= '<span class="btn-text">Seterusnya</span>';
            $html .= '<i class="fas fa-chevron-right"></i>';
            $html .= '</a>';
        } else {
            $html .= '<span class="pagination-btn pagination-btn-disabled">';
            $html .= '<span class="btn-text">Seterusnya</span>';
            $html .= '<i class="fas fa-chevron-right"></i>';
            $html .= '</span>';
        }
        
        $html .= '</nav>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

