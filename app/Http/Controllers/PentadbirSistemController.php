<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\LogAktiviti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class PentadbirSistemController extends Controller
{
    /**
     * Check if current user is assigned to this permohonan
     * Note: ulasan_pentadbir_sistem_by is cast to array in model, so it's always an array
     */
    protected function isPentadbirAssigned($permohonan)
    {
        $currentUserId = Auth::id();
        $assignedPentadbirIds = $permohonan->ulasan_pentadbir_sistem_by;
        
        // After casting, this should always be an array
        if (is_array($assignedPentadbirIds)) {
            return in_array((string)$currentUserId, array_map('strval', $assignedPentadbirIds));
        } elseif ($assignedPentadbirIds !== null) {
            // Fallback for old integer values before migration
            return ($assignedPentadbirIds == $currentUserId);
        }
        
        return false;
    }

    /**
     * Display pentadbir_sistem dashboard with statistics
     */
    public function dashboard()
    {
        try {
            $currentUserId = Auth::id();
            
            // 1. Calculate LULUS (Completed by user)
            // Rules: Status Pegawai 'Lulus' AND:
            // (a) I have entered maklumat_akses (New Logic - Implicit Lulus)
            // (b) OR Status Pentadbir 'Lulus' AND I am the SINGLE assignment (Legacy Logic)
            $lulus = Permohonan::where('status_pegawai', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    $q->whereRaw("JSON_SEARCH(maklumat_akses, 'one', ?, NULL, '$**.entered_by') IS NOT NULL", [(string)$currentUserId])
                      ->orWhere(function($sub) use ($currentUserId) {
                          $sub->where('status_pentadbir_sistem', 'lulus')
                              ->where('ulasan_pentadbir_sistem_by', $currentUserId); // 
                      });
                })
                ->count();

            // 2. Calculate DITOLAK (Rejected by user)
            $tolak = Permohonan::where('status_pegawai', 'lulus')
                ->where('status_pentadbir_sistem', 'tolak')
                ->where(function($q) use ($currentUserId) {
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                       ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->count();

            // 3. Calculate KIV (KIV by user)
            $kiv = Permohonan::where('status_pegawai', 'lulus')
                ->where('status_pentadbir_sistem', 'KIV')
                ->where(function($q) use ($currentUserId) {
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                       ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->count();

            // 4. Calculate Pending
            // Rules: Assigned to user AND:
            // (a) Status is NULL 
            // (b) OR (Status is Lulus AND I haven't entered data AND it's NOT a single-assignment legacy case)
            $pending = Permohonan::where('status_pegawai', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                      ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->where(function($q) use ($currentUserId) {
                    $q->whereNull('status_pentadbir_sistem')
                      ->orWhere(function($sub) use ($currentUserId) {
                          $sub->where('status_pentadbir_sistem', 'lulus')
                              // Exclude if Single Assignee (Legacy Lulus) - these are "Done"
                              ->where('ulasan_pentadbir_sistem_by', '!=', $currentUserId);
                      });
                })
                // Also exclude if I have already entered maklumat_akses (New Done)
                ->whereRaw("JSON_SEARCH(maklumat_akses, 'one', ?, NULL, '$**.entered_by') IS NULL", [(string)$currentUserId])
                ->count();

            $total = $pending + $lulus + $tolak + $kiv;

            $permohonanData = [
                'total' => $total,
                'lulus' => $lulus,
                'tolak' => $tolak,
                'kiv' => $kiv
            ];

            $data = [
                'lulus' => $lulus,
                'tolak' => $tolak,
                'kiv' => $kiv,
                'total' => $total,
                'permohonanData' => $permohonanData
            ];

            return view('pentadbir_sistem.pentadbir_sistem', $data);
            
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

        return view('pentadbir_sistem.pentadbir_sistem', $data);
        }
    }

    /**
     * Alternative optimized method using single query
     */
    public function dashboardOptimized()
    {
        try {
            $stats = Permohonan::where('status_pegawai', 'lulus')
                ->selectRaw('
                    COUNT(*) as total,
                    SUM(CASE WHEN status_pentadbir_sistem = "lulus" THEN 1 ELSE 0 END) as lulus,
                    SUM(CASE WHEN status_pentadbir_sistem = "tolak" THEN 1 ELSE 0 END) as ditolak,
                    SUM(CASE WHEN status_pentadbir_sistem = "KIV" THEN 1 ELSE 0 END) as kiv
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

            return view('pentadbir_sistem.pentadbir_sistem', $data);
            
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

            return view('pentadbir_sistem.pentadbir_sistem', $data);
        }
    }

    /**
     * Display a listing of the applications for pentadbir_sistem to review
     */
    public function senaraiPermohonan(Request $request)
    {
        try {
            $currentUserId = Auth::id();
            
            // CRITICAL: Only show permohonan assigned to THIS pentadbir
            // AND (Status is NOT rejected/KIV)
            // AND (I have NOT entered maklumat_akses yet)
            $query = Permohonan::with('ulasans')
                ->where('status_pegawai', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    // Check if assigned (either single ID or in JSON array)
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                      ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->where(function($q) {
                    $q->whereNull('status_pentadbir_sistem')
                      ->orWhere('status_pentadbir_sistem', 'lulus'); // Show even if Lulus (others might need to act)
                })
                // Exclude if I have already entered maklumat_akses (Check for string ID)
                ->whereRaw("JSON_SEARCH(maklumat_akses, 'one', ?, NULL, '$**.entered_by') IS NULL", [(string)$currentUserId]);
            
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
                    $query->whereNull('status_pentadbir_sistem');
                } elseif ($request->status === 'kiv') {
                    $query->where('status_pentadbir_sistem', 'KIV');
                } elseif ($request->status === 'ditolak') {
                    $query->where('status_pentadbir_sistem', 'tolak');
                }
            }
            
            // Get paginated results with search parameter preserved
            $permohonans = $query
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->appends($request->only('search', 'status'));
            
            // Calculate statistics - ONLY for assigned permohonan
            $totalPermohonan = Permohonan::where('status_pegawai', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                      ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->where(function($q) {
                    $q->whereNull('status_pentadbir_sistem')
                    ->orWhereIn('status_pentadbir_sistem', ['tolak', 'KIV']);
                })
                ->count();
            
            $kiv = Permohonan::where('status_pegawai', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                      ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->where('status_pentadbir_sistem', 'KIV')
                ->count();
            
            $ditolak = Permohonan::where('status_pegawai', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                      ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->where('status_pentadbir_sistem', 'tolak')
                ->count();
            
            $pending = Permohonan::where('status_pegawai', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                      ->orWhereRaw("JSON_CONTAINS(ulasan_pentadbir_sistem_by, JSON_QUOTE(CAST(? AS CHAR)))", [$currentUserId]);
                })
                ->where(function($q) {
                    $q->whereNull('status_pentadbir_sistem')
                      ->orWhere('status_pentadbir_sistem', 'lulus');
                })
                ->whereRaw("JSON_SEARCH(maklumat_akses, 'one', ?, NULL, '$**.entered_by') IS NULL", [(string)$currentUserId])
                ->count();
            
            return view('pentadbir_sistem.senarai_permohonan', compact(
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
            
            // Check if this pentadbir is assigned to this permohonan
            if (!$this->isPentadbirAssigned($permohonan)) {
                return redirect()->route('pentadbir_sistem.senarai-permohonan')
                    ->with('error', 'Anda tidak mempunyai akses kepada permohonan ini.');
            }
            
            return view('pentadbir_sistem.senarai_permohonan_view', compact('permohonan'));
        } catch (\Exception $e) {
            Log::error('Error showing permohonan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }

    /**
     * Update application status by pentadbir_sistem
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            $validated = $request->validate([
                'status_pentadbir_sistem' => 'required|in:Diluluskan,Ditolak,KIV',
                'ulasan_pentadbir_sistem' => 'required|string|max:1000'
            ], [
                'status_pentadbir_sistem.required' => 'Sila pilih status permohonan.',
                'status_pentadbir_sistem.in' => 'Status tidak sah.',
                'ulasan_pentadbir_sistem.required' => 'Ulasan adalah wajib.',
                'ulasan_pentadbir_sistem.max' => 'Ulasan tidak boleh melebihi 1000 aksara.'
            ]);

            // Update pentadbir_sistem's review
            $permohonan->status_pentadbir_sistem = $validated['status_pentadbir_sistem'];
            $permohonan->ulasan_pentadbir_sistem = $validated['ulasan_pentadbir_sistem'];
            $permohonan->tarikh_ulasan_pentadbir_sistem = now();
            $permohonan->ulasan_pentadbir_sistem_by = Auth::id();

            // Update overall application status based on pentadbir_sistem's decision
            if ($validated['status_pentadbir_sistem'] === 'Diluluskan') {
                $permohonan->status_permohonan = 'Selesai';
            } elseif ($validated['status_pentadbir_sistem'] === 'Ditolak') {
                $permohonan->status_permohonan = 'Ditolak';
            } elseif ($validated['status_pentadbir_sistem'] === 'KIV') {
                $permohonan->status_permohonan = 'KIV';
            }

            $permohonan->save();

            // Log the activity
            LogAktiviti::create([
                'id_user' => Auth::id(),
                'tindakan' => "Kemaskini status permohonan ID {$permohonan->id_permohonan} kepada '{$validated['status_pentadbir_sistem']}' dengan ulasan: " . substr($validated['ulasan_pentadbir_sistem'], 0, 50) . "..."
            ]);

            Log::info('pentadbir_sistem updated status', [
                'permohonan_id' => $id,
                'status' => $validated['status_pentadbir_sistem'],
                'pentadbir_sistem' => auth()->user()->nama ?? 'Unknown'
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
     * Show the form for editing the specified application (pentadbir_sistem version)
     */
    public function edit($id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            // Check if this pentadbir is assigned to this permohonan
            if (!$this->isPentadbirAssigned($permohonan)) {
                return redirect()->route('pentadbir_sistem.senarai-permohonan')
                    ->with('error', 'Anda tidak mempunyai akses kepada permohonan ini.');
            }
            
            // Get all categories as array
            $allKategori = is_array($permohonan->kategori) ? $permohonan->kategori : [$permohonan->kategori];
            
            // Prepare existing maklumat akses data grouped by category
            $existingMaklumatAkses = [];
            if ($permohonan->maklumat_akses) {
                $existingMaklumatAkses = is_array($permohonan->maklumat_akses) 
                    ? $permohonan->maklumat_akses 
                    : [];
            }
            
            return view('pentadbir_sistem.senarai_permohonan_edit', compact(
                'permohonan', 
                'allKategori',
                'existingMaklumatAkses'
            ));
        } catch (\Exception $e) {
            Log::error('Error showing edit form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permohonan tidak dijumpai.');
        }
    }
    
     /**
     * Update the specified application with pentadbir_sistem approval AND maklumat akses
     * UPDATED: Now supports multiple categories with separate maklumat akses
     */
    public function update(Request $request, $id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            // Get all categories
            $allKategori = is_array($permohonan->kategori) ? $permohonan->kategori : [$permohonan->kategori];

            // Base validation rules
            $validationRules = [
                'status_pentadbir_sistem' => 'required|in:Lulus,KIV,Tolak',
                'ulasan_pentadbir_sistem' => 'nullable|string|max:1000',
            ];

            $validationMessages = [
                'status_pentadbir_sistem.required' => 'Sila pilih status keputusan.',
                'status_pentadbir_sistem.in' => 'Status tidak sah.',
                'ulasan_pentadbir_sistem.max' => 'Ulasan tidak boleh melebihi 1000 aksara.',
            ];
            // Jika status "Lulus", maklumat akses adalah PILIHAN mengikut kategori yang pentadbir jaga
            // Hanya kategori yang ada input akan divalidate; kategori lain boleh dikosongkan
            if ($request->status_pentadbir_sistem === 'Lulus') {
                foreach ($allKategori as $kategori) {
                    $categoryKey = $this->getCategoryKey($kategori);
                    $categoryInput = $request->input("maklumat_akses.{$categoryKey}", null);

                    // Langkau kategori yang tiada langsung input (pentadbir lain mungkin akan isi)
                    if ($categoryInput === null) {
                        continue;
                    }

                    // Tambah peraturan untuk kategori yang ADA data
                    $validationRules["maklumat_akses.{$categoryKey}"] = 'array|min:1';
                    $validationMessages["maklumat_akses.{$categoryKey}.min"] = "Kategori {$kategori} memerlukan sekurang-kurangnya satu maklumat akses jika ingin diisi.";

                    if ($kategori === Permohonan::KATEGORI_SERVER || 
                        $kategori === Permohonan::KATEGORI_SISTEM_APLIKASI) {

                        $validationRules["maklumat_akses.{$categoryKey}.*.id_pengguna"] = 'required|string|max:255';
                        $validationRules["maklumat_akses.{$categoryKey}.*.kata_laluan"] = 'required|string|min:8|max:255';
                        $validationRules["maklumat_akses.{$categoryKey}.*.kumpulan_capaian"] = 'required|string|max:255';

                        $validationMessages["maklumat_akses.{$categoryKey}.*.id_pengguna.required"] = "ID Pengguna wajib untuk {$kategori}";
                        $validationMessages["maklumat_akses.{$categoryKey}.*.kata_laluan.required"] = "Kata Laluan wajib untuk {$kategori}";
                        $validationMessages["maklumat_akses.{$categoryKey}.*.kata_laluan.min"] = "Kata Laluan mestilah sekurang-kurangnya 8 aksara";
                        $validationMessages["maklumat_akses.{$categoryKey}.*.kumpulan_capaian.required"] = "Kumpulan Capaian wajib untuk {$kategori}";

                    } elseif ($kategori === Permohonan::KATEGORI_EMEL) {

                        $validationRules["maklumat_akses.{$categoryKey}.*.id_emel"] = 'required|email|max:255';
                        $validationRules["maklumat_akses.{$categoryKey}.*.kata_laluan"] = 'required|string|min:8|max:255';

                        $validationMessages["maklumat_akses.{$categoryKey}.*.id_emel.required"] = "ID Emel wajib untuk {$kategori}";
                        $validationMessages["maklumat_akses.{$categoryKey}.*.id_emel.email"] = "Format emel tidak sah";
                        $validationMessages["maklumat_akses.{$categoryKey}.*.kata_laluan.required"] = "Kata Laluan wajib untuk {$kategori}";
                        $validationMessages["maklumat_akses.{$categoryKey}.*.kata_laluan.min"] = "Kata Laluan mestilah sekurang-kurangnya 8 aksara";
                    }
                }
            }

            $validated = $request->validate($validationRules, $validationMessages);

            // WAJIB: Jika status Lulus, pentadbir mesti isi sekurang-kurangnya satu maklumat akses (apa-apa kategori)
            if ($validated['status_pentadbir_sistem'] === 'Lulus') {
                $hasAtLeastOne = false;
                
                // 1. Check Request Data (New/My Data)
                foreach ($allKategori as $kategori) {
                    $categoryKey = $this->getCategoryKey($kategori);
                    $categoryData = $request->input("maklumat_akses.{$categoryKey}", []);
                    if (!is_array($categoryData)) {
                        continue;
                    }
                    foreach ($categoryData as $aksesData) {
                        if ($kategori === Permohonan::KATEGORI_SERVER || $kategori === Permohonan::KATEGORI_SISTEM_APLIKASI) {
                            if (!empty($aksesData['id_pengguna'] ?? null) && !empty($aksesData['kata_laluan'] ?? null) && !empty($aksesData['kumpulan_capaian'] ?? null)) {
                                $hasAtLeastOne = true;
                                break 2;
                            }
                        } elseif ($kategori === Permohonan::KATEGORI_EMEL) {
                            if (!empty($aksesData['id_emel'] ?? null) && !empty($aksesData['kata_laluan'] ?? null)) {
                                $hasAtLeastOne = true;
                                break 2;
                            }
                        }
                    }
                }
                
                // 2. Check Existing Data (Other/Legacy Data)
                if (!$hasAtLeastOne) {
                    $existingMaklumatAkses = $permohonan->maklumat_akses;
                    if (is_array($existingMaklumatAkses) && !empty($existingMaklumatAkses)) {
                         foreach ($existingMaklumatAkses as $cat => $items) {
                            if (is_array($items) && !empty($items)) {
                                // Assume existing data in DB is valid enough if present
                                $hasAtLeastOne = true; 
                                break;
                            }
                         }
                    }
                }

                if (!$hasAtLeastOne) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'maklumat_akses' => ['Anda wajib mengisi sekurang-kurangnya satu maklumat akses dalam mana-mana kategori (ID Pengguna/Emel, Kata Laluan, dsb.) sebelum boleh menghantar permohonan dengan status Lulus.'],
                    ]);
                }
            }

            // Update pentadbir_sistem's decision
            $permohonan->status_pentadbir_sistem = $validated['status_pentadbir_sistem'];
            $permohonan->ulasan_pentadbir_sistem = $validated['ulasan_pentadbir_sistem'] ?? null;
            $permohonan->tarikh_ulasan_pentadbir_sistem = now();
            // Jangan override senarai assignment pentadbir (ulasan_pentadbir_sistem_by) yang telah dipilih oleh Pegawai.

            // If approved, save / merge maklumat akses untuk kategori yang diisi oleh pentadbir ini
            if ($validated['status_pentadbir_sistem'] === 'Lulus') {
                // Ambil maklumat akses sedia ada (daripada pentadbir lain) dan gabungkan
                $existingMaklumatAkses = $permohonan->maklumat_akses;
                $allMaklumatAkses = is_array($existingMaklumatAkses) ? $existingMaklumatAkses : [];
                
                // Process each category
                // Process each category
                foreach ($allKategori as $kategori) {
                    $categoryKey = $this->getCategoryKey($kategori);
                    
                    // 1. Get existing data for this category
                    $existingCategoryData = $existingMaklumatAkses[$kategori] ?? [];
                    
                    // 2. Filter out data entered by OTHER admins (preserve it)
                    $othersData = [];
                    foreach ($existingCategoryData as $item) {
                        // If item has entered_by AND it's NOT the current user, keep it
                        if (isset($item['entered_by']) && $item['entered_by'] != Auth::id()) {
                            $othersData[] = $item;
                        }
                        // Items without entered_by (legacy) or with entered_by == Auth::id() are considered "adoptable/editable"
                        // and are expected to be present in the request if they are to be kept.
                    }

                    // 3. Process new/edited data from request (My Data)
                    $categoryData = $request->input("maklumat_akses.{$categoryKey}", []);
                    $myProcessedData = [];
                    
                    foreach ($categoryData as $aksesData) {
                        $processedData = [];
                        
                        // Extract fields based on category type
                        if ($kategori === Permohonan::KATEGORI_SERVER || 
                            $kategori === Permohonan::KATEGORI_SISTEM_APLIKASI) {
                            $processedData = [
                                'id_pengguna' => $aksesData['id_pengguna'] ?? null,
                                'kata_laluan' => $aksesData['kata_laluan'] ?? null,
                                'kumpulan_capaian' => $aksesData['kumpulan_capaian'] ?? null,
                                'entered_by' => (string)Auth::id(),
                            ];
                        } elseif ($kategori === Permohonan::KATEGORI_EMEL) {
                            $processedData = [
                                'id_emel' => $aksesData['id_emel'] ?? null,
                                'kata_laluan' => $aksesData['kata_laluan'] ?? null,
                                'entered_by' => (string)Auth::id(),
                            ];
                        }
                        
                        // Only add if data is not empty
                        // Note: we check key fields to avoid empty rows
                        if (!empty(array_filter($processedData, function($v, $k) { 
                            return $k !== 'entered_by' && !empty($v); 
                        }, ARRAY_FILTER_USE_BOTH))) {
                            $myProcessedData[] = $processedData;
                        }
                    }
                    
                    // 4. Merge preserved "others" data with "my" new data
                    $finalCategoryData = array_merge($othersData, $myProcessedData);
                    
                    // Store if not empty
                    if (!empty($finalCategoryData)) {
                        $allMaklumatAkses[$kategori] = $finalCategoryData;
                    }
                }

                // Save all maklumat akses (will be encrypted automatically by model)
                $permohonan->maklumat_akses = $allMaklumatAkses;
                $permohonan->tarikh_maklumat_akses = now();
                
                // Tentukan status keseluruhan berdasarkan semua peranan + maklumat akses
                $permohonan->determineOverallStatus();
                
                Log::info('Multi-category maklumat akses saved', [
                    'permohonan_id' => $id,
                    'categories' => array_keys($allMaklumatAkses),
                    'total_entries' => array_sum(array_map('count', $allMaklumatAkses))
                ]);
            } else {
                // Update overall status based on pentadbir_sistem decision
                if ($validated['status_pentadbir_sistem'] === 'KIV') {
                    $permohonan->status_permohonan = 'Dalam Proses';
                } elseif ($validated['status_pentadbir_sistem'] === 'Tolak') {
                    $permohonan->status_permohonan = 'Dalam Proses';
                }
            }

            // Save the record
            $permohonan->save();

            // Log the activity
            \App\Models\LogAktiviti::create([
                'id_user' => \Illuminate\Support\Facades\Auth::id(),
                'tindakan' => "Kemaskini maklumat akses & status permohonan ID {$permohonan->id_permohonan} kepada '{$validated['status_pentadbir_sistem']}'"
            ]);

            // Send notification email
            // Only send 'Selesai' notification if ALL requested categories have Maklumat Akses filled
            $shouldNotify = true;

            if ($validated['status_pentadbir_sistem'] === 'Lulus') {
                $requestedCategories = $permohonan->kategori ?? [];
                // Get keys of filled categories (from allMaklumatAkses we just prepared)
                $filledCategories = array_keys($allMaklumatAkses);
                
                // Check if all requested categories are in filled categories
                // array_diff returns values in requested that are NOT in filled
                $missingCategories = array_diff($requestedCategories, $filledCategories);
                
                if (!empty($missingCategories)) {
                    $shouldNotify = false;
                    Log::info('Permohonan Lulus but legacy/other admin access info incomplete. Notification delayed.', [
                        'permohonan_id' => $id,
                        'missing_categories' => $missingCategories
                    ]);
                }
            }

            if ($shouldNotify) {
                NotificationHelper::handleWorkflowNotification(
                    $permohonan,
                    auth()->user(),
                    'pentadbir_sistem',
                    $validated['status_pentadbir_sistem'],
                    $validated['ulasan_pentadbir_sistem'] ?? null
                );
            }

            // Log the update
            Log::info('Pentadbir sistem updated permohonan with multi-category support', [
                'permohonan_id' => $id,
                'updated_by' => auth()->user()->nama ?? 'Unknown',
                'pentadbir_sistem_id' => Auth::id(), 
                'pentadbir_sistem_status' => $validated['status_pentadbir_sistem'],
                'categories_processed' => count($allKategori),
                'has_maklumat_akses' => $permohonan->hasMaklumatAkses(),
                'timestamp' => $permohonan->tarikh_ulasan_pentadbir_sistem,
                'email_sent' => true
            ]);

            return redirect()->route('pentadbir_sistem.senarai-permohonan')
                ->with('success', 'Keputusan berjaya disimpan untuk semua kategori dan notifikasi email telah dihantar!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating permohonan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terdapat ralat semasa menyimpan keputusan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Convert category name to a key suitable for form field names
     */
    private function getCategoryKey($kategori)
    {
        // Convert "Server/Pangkalan Data" to "server_pangkalan_data"
        return strtolower(str_replace(['/', ' '], ['_', '_'], $kategori));
    }

    /**
     * Get validation rules for maklumat akses based on kategori
     * Returns rules for validating array of entries
     */
    private function getMaklumatAksesValidationRules(array $kategori): array
    {
        switch ($kategori) {
            case Permohonan::KATEGORI_SERVER:
            case Permohonan::KATEGORI_SISTEM_APLIKASI:
                return [
                    'maklumat_akses.*.id_pengguna' => 'required|string|max:255',
                    'maklumat_akses.*.kata_laluan' => 'required|string|min:8|max:255',
                    'maklumat_akses.*.kumpulan_capaian' => 'required|string|max:255',
                ];
            
            case Permohonan::KATEGORI_EMEL:
                return [
                    'maklumat_akses.*.id_emel' => 'required|email|max:255',
                    'maklumat_akses.*.kata_laluan' => 'required|string|min:8|max:255',
                ];
            
            default:
                return [];
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
     * Display application history (reviewed by pentadbir_sistem)
     */
   public function senaraiPermohonanLama(Request $request)
    {
        try {
            $currentUserId = Auth::id();
            
            // Base query: applications that pentadbir_sistem has APPROVED
            // AND (Either I was the single approver OR I have entered maklumat_akses)
            $query = Permohonan::where('status_pentadbir_sistem', 'lulus')
                ->where(function($q) use ($currentUserId) {
                    // Legacy check: Single approver
                    $q->where('ulasan_pentadbir_sistem_by', $currentUserId)
                      // New check: I have entered maklumat_akses (JSON check for string ID)
                      ->orWhereRaw("JSON_SEARCH(maklumat_akses, 'one', ?, NULL, '$**.entered_by') IS NOT NULL", [(string)$currentUserId]);
                })
                ->whereNotNull('tarikh_ulasan_pentadbir_sistem');

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
                ->orderBy('tarikh_ulasan_pentadbir_sistem', 'desc')
                ->paginate(10)
                ->appends($request->only('search'));
            
            // Optional: Count ALL approved (for reference)
            $totalAll = Permohonan::where('status_pentadbir_sistem', 'lulus')
                ->where('ulasan_pentadbir_sistem_by', $currentUserId)
                ->whereNotNull('tarikh_ulasan_pentadbir_sistem')
                ->count();
            
            return view('pentadbir_sistem.senarai_permohonan_lama', compact('permohonans', 'total', 'totalAll'));

        } catch (\Exception $e) {
            Log::error('Error fetching old applications: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat senarai permohonan lama.');
        }
    }
}