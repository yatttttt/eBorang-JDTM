<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\LogAktiviti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Mail;              
use App\Mail\PermohonanBerjayaNotification;      

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Permohonan::with('ulasans');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemohon', 'LIKE', "%{$search}%")
                  ->orWhere('no_kp', 'LIKE', "%{$search}%")
                  ->orWhere('id_permohonan', 'LIKE', "%{$search}%");
            });
        }
        
        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'lengkap') {
                $query->whereNotNull('status_pegawai')
                      ->where('status_pegawai', 'Diluluskan');
            } elseif ($request->status === 'tidak_lengkap') {
                $query->where(function($q) {
                    $q->whereNull('status_pegawai')
                      ->orWhere('status_pegawai', '!=', 'Diluluskan');
                });
            }
        }
        
        // Get paginated results
        $permohonans = $query->orderBy('created_at', 'desc')->paginate(15);

        // Kumpul semua ID Pentadbir Sistem yang telah ditugaskan dalam senarai ini
        $pentadbirIds = [];
        foreach ($permohonans as $permohonan) {
            $assigned = $permohonan->ulasan_pentadbir_sistem_by;
            if (is_array($assigned)) {
                foreach ($assigned as $id) {
                    if ($id !== null && $id !== '') {
                        $pentadbirIds[] = (int) $id;
                    }
                }
            } elseif (!is_null($assigned)) {
                $pentadbirIds[] = (int) $assigned;
            }
        }

        $pentadbirUsers = collect();
        if (!empty($pentadbirIds)) {
            $pentadbirUsers = User::whereIn('id_user', array_unique($pentadbirIds))->get()->keyBy('id_user');
        }
        
        // Calculate statistics
        $totalPermohonan = Permohonan::count();
        $lengkap = Permohonan::where('status_pegawai', 'Diluluskan')->count();
        $tidakLengkap = $totalPermohonan - $lengkap;
        $pending = Permohonan::where('status_permohonan', 'Dalam Proses')->count();
        
        return view('admin.senarai_permohonan', compact(
            'permohonans', 
            'totalPermohonan', 
            'lengkap', 
            'tidakLengkap', 
            'pending',
            'pentadbirUsers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.muat_naik_permohonan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug: Log all incoming request data
            Log::info('Request data received:', $request->all());

            $validated = $request->validate([
                'no_kawalan'   => 'required|string|max:255',
                'jenis_permohonan' => 'required|array|min:1',
                'jenis_permohonan.*' => 'required|string|max:50',
                'nama_pemohon' => 'required|string|max:100',
                'no_kp'        => 'required|string|max:25',
                'jawatan'      => 'required|string|max:100',
                'jabatan'      => 'required|string|max:100',
                'fail_borang'  => 'required|file|mimes:pdf|max:10240',
                'kategori'     => 'required|array|min:1',
                'kategori.*'   => 'required|string|max:50',
                'subkategori'  => 'nullable|array',
                'subkategori.*'=> 'nullable|string|max:50',
            ], [
                // Custom messages
                'no_kawalan.required' => 'Sila masukkan nombor kawalan.',
                'jenis_permohonan.required' => 'Sila pilih sekurang-kurangnya satu jenis permohonan.',
                'fail_borang.required' => 'Sila muat naik fail borang.',
                'fail_borang.mimes'    => 'Fail borang mestilah dalam format PDF.',
                'fail_borang.max'      => 'Fail borang tidak boleh melebihi 10MB.',
            ]);

            Log::info('Validation passed:', $validated);

            // Handle file upload
            if (!$request->hasFile('fail_borang')) {
                throw new \Exception('File upload failed - no file received');
            }
            
            $filePath = $request->file('fail_borang')->store('permohonan', 'public');
            Log::info('File uploaded to: ' . $filePath);

            // Process jenis_permohonan array - filter and save all non-empty values (required field)
            $jenisPermohonanArray = collect($validated['jenis_permohonan'])->filter(function($value) {
                return !empty($value);
            })->values()->toArray();

            if (empty($jenisPermohonanArray)) {
                throw new \Exception('Jenis Permohonan is required but no valid jenis permohonan found');
            }

            // Process kategori array - filter and save all non-empty values (required field)
            $kategoriArray = collect($validated['kategori'])->filter(function($value) {
                return !empty($value);
            })->values()->toArray();

            if (empty($kategoriArray)) {
                throw new \Exception('Kategori is required but no valid kategori found');
            }

            // Process subkategori array - filter and save all non-empty values (nullable field)
            $subkategoriArray = null;
            if (isset($validated['subkategori']) && is_array($validated['subkategori'])) {
                $subkategoriFilled = collect($validated['subkategori'])->filter(function($value) {
                    return !empty($value);
                })->values()->toArray();
                $subkategoriArray = !empty($subkategoriFilled) ? $subkategoriFilled : null;
            }

            // kategori and subkategori will be automatically converted to JSON by Model casting
            $dataToInsert = [
                'no_kawalan' => $validated['no_kawalan'],
                'jenis_permohonan' => $jenisPermohonanArray,
                'nama_pemohon' => $validated['nama_pemohon'],
                'no_kp' => $validated['no_kp'], 
                'jawatan' => $validated['jawatan'],
                'jabatan' => $validated['jabatan'], 
                'fail_borang' => $filePath,
                'kategori' => $kategoriArray, 
                'subkategori' => $subkategoriArray, 
                'tarikh_hantar' => now(),
            ];

            Log::info('Data to insert:', $dataToInsert);

            // Create the record
            $permohonan = Permohonan::create($dataToInsert);

            Log::info('Permohonan created successfully with ID: ' . $permohonan->id_permohonan);

            // Log the activity
            LogAktiviti::create([
                'id_user' => Auth::id(),
                'tindakan' => "Muat naik permohonan baru (ID: {$permohonan->id_permohonan}) atas nama {$validated['nama_pemohon']}"
            ]);

            // ✉️ 【TAMBAH BARU】Email kepada Admin yang submit (Confirmation)
            Log::info('=== EMAIL ADMIN CONFIRMATION START ===', [
                'permohonan_id' => $permohonan->id_permohonan
            ]);

            try {
                // CHECK: User authenticated and has email?
                if (!auth()->check()) {
                    throw new \Exception('User not authenticated');
                }
                
                $adminUser = auth()->user();
                $adminEmail = $adminUser->email;
                
                if (empty($adminEmail)) {
                    Log::error('Admin email is empty', [
                        'user_id' => $adminUser->id,
                        'user_name' => $adminUser->name
                    ]);
                    throw new \Exception('Admin email is empty or null');
                }
                
                Log::info('Sending confirmation email to admin', [
                    'to' => $adminEmail,
                    'permohonan_id' => $permohonan->id_permohonan,
                    'user_id' => $adminUser->id
                ]);
                
                // Send email
                Mail::to($adminEmail)->send(new PermohonanBerjayaNotification($permohonan));
                
                // Send system notification (in-app notification)
                NotificationHelper::notifyAdminsApplicationSubmitted($permohonan, auth()->user());
                
                Log::info('✅ Confirmation email sent successfully!', [
                    'to' => $adminEmail,
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
                
            } catch (\Exception $e) {
                Log::error('❌ Failed to send confirmation email', [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'permohonan_id' => $permohonan->id_permohonan,
                    'user_email' => auth()->user()->email ?? 'no email',
                    'trace' => $e->getTraceAsString()
                ]);
            }

            Log::info('=== EMAIL ADMIN CONFIRMATION END ===');

            // ✉️ Email kepada Pengarah (existing)
            try {
                Log::info('Admin created new permohonan, notifying Pengarah', [
                    'permohonan_id' => $permohonan->id_permohonan
                ]);

                NotificationHelper::notifyNextReviewer($permohonan, 'pengarah');

                Log::info('Pengarah notified successfully', [
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to notify Pengarah', [
                    'permohonan_id' => $permohonan->id_permohonan,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Don't fail entire request if email fails
            }

            return redirect()->back()->with('success', 'Permohonan berjaya dihantar dan Pengarah telah dimaklumkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating permohonan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terdapat ralat semasa menghantar permohonan. Sila cuba lagi. Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    
    public function senaraiPermohonan()
    {
        $permohonans = Permohonan::all();
        return view('admin.senarai_permohonan', compact('permohonans'));
    }

    /**
    * Display the specified resource (detail view).
    */
    public function show($id)
    {
        $permohonan = Permohonan::with('ulasans')->findOrFail($id);

        // Senarai Pentadbir Sistem yang ditugaskan (sokong format array, integer lama, dan string JSON)
        $assignedPentadbir = collect([]);
        $pentadbirIds = $permohonan->ulasan_pentadbir_sistem_by;

        if ($pentadbirIds !== null && $pentadbirIds !== '') {
            if (is_array($pentadbirIds)) {
                $ids = array_values(array_filter(array_map('intval', $pentadbirIds)));
            } elseif (is_numeric($pentadbirIds)) {
                $ids = [(int) $pentadbirIds];
            } else {
                $decoded = json_decode($pentadbirIds, true);
                $ids = is_array($decoded) ? array_values(array_filter(array_map('intval', $decoded))) : [];
            }
            if (!empty($ids)) {
                $assignedPentadbir = User::whereIn('id_user', $ids)->get();
            }
        }

        return view('admin.senarai_permohonan_view', compact('permohonan', 'assignedPentadbir'));
    }
    
    //Show the form for editing the specified resource.
    public function edit($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('admin.senarai_permohonan_edit', compact('permohonan'));
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);

            $validated = $request->validate([
                'nama_pemohon' => 'required|string|max:100',
                'no_kp'        => 'required|string|max:25',
                'jawatan'      => 'required|string|max:100',
                'jabatan'      => 'required|string|max:100',
                'fail_borang'  => 'nullable|file|mimes:pdf|max:10240',
                'subkategori'  => 'nullable|string|max:255',
            ]);

            // Update fields directly
            $permohonan->nama_pemohon = $validated['nama_pemohon'];
            $permohonan->no_kp = $validated['no_kp'];
            $permohonan->jawatan = $validated['jawatan'];
            $permohonan->jabatan = $validated['jabatan'];
            $permohonan->subkategori = $validated['subkategori'];

            // Handle file upload
            if ($request->hasFile('fail_borang')) {
                if ($permohonan->fail_borang && \Storage::disk('public')->exists($permohonan->fail_borang)) {
                    \Storage::disk('public')->delete($permohonan->fail_borang);
                }
                $permohonan->fail_borang = $request->file('fail_borang')->store('permohonan', 'public');
            }

            $permohonan->save();

            return redirect()->route('admin.senarai_permohonan')->with('success', 'Permohonan berjaya dikemaskini.');

        } catch (\Exception $e) {
            Log::error('Error updating permohonan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terdapat ralat semasa mengemaskini permohonan.')
                ->withInput();
        }
    }


    // Remove the specified resource from storage.
    public function destroy($id)
    {
        try {
            $permohonan = Permohonan::findOrFail($id);
            
            // Delete associated file if exists
            if ($permohonan->fail_borang && \Storage::disk('public')->exists($permohonan->fail_borang)) {
                \Storage::disk('public')->delete($permohonan->fail_borang);
            }
            
            // Delete the record
            $permohonan->delete();
            
            // Redirect back to list with success message
            return redirect()->route('admin.senarai_permohonan')
                ->with('success', 'Permohonan berjaya dipadam!');
                
        } catch (\Exception $e) {
            Log::error('Error deleting permohonan: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terdapat ralat semasa memadam permohonan.');
        }
    }

    // Download the specified resource's file.
    public function download($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        
        $filePath = storage_path('app/public/' . $permohonan->fail_borang);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }
        
        return response()->download($filePath);
    }

    public function senaraiPermohonanLama()
    {
        // Get finalized applications (approved by pegawai/pentadbir sistem)
        $permohonans = Permohonan::where('status_pegawai', 'Diluluskan')
            ->where('status_permohonan', 'Selesai')
            ->with('ulasans')
            ->orderBy('tarikh_ulasan_pegawai', 'desc')
            ->paginate(15);
        
        // Statistics
        $total = Permohonan::where('status_pegawai', 'Diluluskan')
            ->where('status_permohonan', 'Selesai')
            ->count();
        
        return view('admin.senarai_permohonan_lama', compact('permohonans', 'total'));
    }
}
