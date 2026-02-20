<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Permohonan extends Model
{
    use HasFactory;

    /**
     * Jenis Permohonan constants
     */
    public const JENIS_PENDAFTARAN_BARU = 'Pendaftaran Baru';
    public const JENIS_KEMASKINI = 'Kemaskini Akaun';
    public const JENIS_PENAMATAN = 'Penamatan Akaun';
    
    /**
     * Category constants
     */
    public const KATEGORI_SERVER = 'Server/Pangkalan Data';
    public const KATEGORI_SISTEM_APLIKASI = 'Sistem Aplikasi/Modul';
    public const KATEGORI_EMEL = 'Emel Rasmi MBSA';

    /**
     * Status constants
     */
    public const STATUS_DILULUSKAN = 'Diluluskan';
    public const STATUS_DITOLAK = 'Ditolak';
    public const STATUS_KIV = 'KIV';
    public const STATUS_LULUS = 'Lulus';
    public const STATUS_TOLAK = 'Tolak';
    public const STATUS_SELESAI = 'Selesai';
    public const STATUS_DALAM_PROSES = 'Dalam Proses';

    /**
     * The table associated with the model.
     */
    protected $table = 'permohonans';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_permohonan';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'no_kawalan',
        'jenis_permohonan',
        'nama_pemohon',
        'no_kp',
        'jawatan',
        'jabatan',
        'fail_borang',
        'tarikh_hantar',
        'status_pengarah',
        'status_pegawai',
        'status_pentadbir_sistem',
        'status_permohonan',
        'ulasan_pengarah',
        'tarikh_ulasan_pengarah',
        'ulasan_pengarah_by',
        'ulasan_pegawai',
        'tarikh_ulasan_pegawai',
        'ulasan_pegawai_by',
        'ulasan_pentadbir_sistem',
        'tarikh_ulasan_pentadbir_sistem',
        'ulasan_pentadbir_sistem_by',
        'kategori',
        'subkategori',
        'maklumat_akses',
        'tarikh_maklumat_akses',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'jenis_permohonan' => 'array',
        'kategori' => 'array',        
        'subkategori' => 'array',
        'ulasan_pentadbir_sistem_by' => 'array',
        'tarikh_hantar' => 'datetime',
        'tarikh_ulasan_pengarah' => 'datetime',
        'tarikh_ulasan_pegawai' => 'datetime',
        'tarikh_ulasan_pentadbir_sistem' => 'datetime',
        'maklumat_akses' => 'array',
        'tarikh_maklumat_akses' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    protected $hidden = [
        // Empty - allow access to maklumat_akses
    ];

    public function getFormattedKategoriAttribute()
    {
        $kategori = $this->kategori;

        if (empty($kategori)) {
            return 'Tiada';
        }

        // If array (because of cast)
        if (is_array($kategori)) {
            return implode(', ', $kategori);
        }

        // Fallback if string
        return $kategori;
    }

    /**
     * Get formatted subkategori without quotes and brackets
     * Handles: JSON arrays, single values, empty values
     * @return string
     */
    public function getFormattedSubkategoriAttribute(): string
{
    $sub = $this->subkategori;

    // CASE 1: Empty
    if (empty($sub)) {
        return 'Tiada';
    }

    // CASE 2: Already array (because of cast)
    if (is_array($sub)) {
        $filtered = array_filter($sub);
        return implode(', ', $filtered);
    }

    // CASE 3: If string JSON, decode it
    if (is_string($sub) && 
        (str_starts_with(trim($sub), '[') || str_starts_with(trim($sub), '{')))
    {
        $decoded = json_decode($sub, true);
        if (is_array($decoded)) {
            return implode(', ', array_filter($decoded));
        }
    }

    // CASE 4: Normal string (remove brackets/quotes)
    $clean = str_replace(['[', ']', '"', "'"], '', $sub);
    return trim($clean) ?: 'Tiada';
}


    /**
     * Get subkategori as array (useful for forms/selects)
     * 
     */
    public function getSubkategoriArrayAttribute(): array
    {
        if (empty($this->subkategori)) {
            return [];
        }
        
        $subkategori = $this->subkategori;
        
        // Try JSON decode first
        if (str_starts_with(trim($subkategori), '[') || str_starts_with(trim($subkategori), '{')) {
            try {
                $decoded = json_decode($subkategori, true);
                if (is_array($decoded)) {
                    return array_filter(array_values($decoded));
                }
            } catch (\Exception $e) {
                // Continue to fallback
            }
        }
        
        // Fallback: Split by comma
        $items = explode(',', str_replace(['"', '[', ']', '{', '}'], '', $subkategori));
        return array_filter(array_map('trim', $items));
    }

    /**
     * COUNT SUBKATEGORI ITEMS
     * 
     * @return int
     */
    public function getSubkategoriCountAttribute(): int
    {
        return count($this->subkategori_array);
    }

    public function getStatusClassAttribute()
    {
        $status = strtolower($this->status_permohonan);
        
        $statusMap = [
            'kiv' => 'pending',
            'selesai' => 'approved',
            'diluluskan' => 'approved',
            'lulus' => 'approved',
            'ditolak' => 'rejected',
            'dalam proses' => 'default',
        ];
        
        return $statusMap[$status] ?? 'pending';
    }

    /**
     * Relationship with Ulasan model
     */
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'id_permohonan', 'id_permohonan');
    }

    /**
     * Relationship: User yang meluluskan sebagai Pengarah
     */
    public function userPengarah()
    {
        return $this->belongsTo(User::class, 'ulasan_pengarah_by', 'id_user');
    }
    
    /**
     * Relationship: User yang meluluskan sebagai Pegawai
     */
    public function userPegawai()
    {
        return $this->belongsTo(User::class, 'ulasan_pegawai_by', 'id_user');
    }
    
    /**
     * Relationship: User yang meluluskan sebagai Pentadbir Sistem
     */
    public function userPentadbirSistem()
    {
        return $this->belongsTo(User::class, 'ulasan_pentadbir_sistem_by', 'id_user');
    }

    /**
    * Encrypt sensitive data before saving to database
    */
    public function setMaklumatAksesAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['maklumat_akses'] = null;
            return;
        }

        // Check if it's multi-category structure (associative array with category keys)
        if (is_array($value) && !isset($value[0])) {
            $encryptedData = [];
            
            foreach ($value as $kategori => $entries) {
                $encryptedEntries = [];
                
                if (is_array($entries)) {
                    foreach ($entries as $entry) {
                        if (is_array($entry) && isset($entry['kata_laluan']) && !empty($entry['kata_laluan'])) {
                            $entry['kata_laluan'] = Crypt::encryptString($entry['kata_laluan']);
                        }
                        $encryptedEntries[] = $entry;
                    }
                }
                
                $encryptedData[$kategori] = $encryptedEntries;
            }
            
            $this->attributes['maklumat_akses'] = json_encode($encryptedData);
            return;
        }

        // Original flat array format (keep for backward compatibility)
        if (is_array($value) && isset($value[0]) && is_array($value[0])) {
            // Multiple entries format
            $encryptedArray = [];
            foreach ($value as $entry) {
                if (is_array($entry) && isset($entry['kata_laluan']) && !empty($entry['kata_laluan'])) {
                    $entry['kata_laluan'] = Crypt::encryptString($entry['kata_laluan']);
                }
                $encryptedArray[] = $entry;
            }
            $this->attributes['maklumat_akses'] = json_encode($encryptedArray);
        } 
        // Single entry format
        else if (is_array($value) && isset($value['kata_laluan']) && !empty($value['kata_laluan'])) {
            $value['kata_laluan'] = Crypt::encryptString($value['kata_laluan']);
            $this->attributes['maklumat_akses'] = json_encode($value);
        }
    }

    /**
    * Decrypt sensitive data when retrieving from database
    */
    public function getMaklumatAksesAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        
        $data = json_decode($value, true);
        
        if (!is_array($data)) {
            return null;
        }

        // Check if multi-category structure (associative array, not indexed)
        $firstKey = array_key_first($data);
        if (!is_numeric($firstKey) && is_array($data[$firstKey])) {
            // Multi-category format
            $decryptedData = [];
            
            foreach ($data as $kategori => $entries) {
                $decryptedEntries = [];
                
                if (is_array($entries)) {
                    foreach ($entries as $entry) {
                        if (is_array($entry) && isset($entry['kata_laluan']) && !empty($entry['kata_laluan'])) {
                            try {
                                $entry['kata_laluan'] = Crypt::decryptString($entry['kata_laluan']);
                            } catch (\Exception $e) {
                                $entry['kata_laluan'] = null;
                            }
                        }
                        $decryptedEntries[] = $entry;
                    }
                }
                
                $decryptedData[$kategori] = $decryptedEntries;
            }
            
            return $decryptedData;
        }

        // Original flat format (backward compatibility)
        if (isset($data[0]) && is_array($data[0])) {
            // Multiple entries - decrypt each password
            $decryptedArray = [];
            foreach ($data as $entry) {
                if (is_array($entry) && isset($entry['kata_laluan']) && !empty($entry['kata_laluan'])) {
                    try {
                        $entry['kata_laluan'] = Crypt::decryptString($entry['kata_laluan']);
                    } catch (\Exception $e) {
                        $entry['kata_laluan'] = null;
                    }
                }
                $decryptedArray[] = $entry;
            }
            return $decryptedArray;
        } 
        // Single entry
        else {
            if (isset($data['kata_laluan']) && !empty($data['kata_laluan'])) {
                try {
                    $data['kata_laluan'] = Crypt::decryptString($data['kata_laluan']);
                } catch (\Exception $e) {
                    $data['kata_laluan'] = null;
                }
            }
            return [$data];
        }
    }

    /**
    * Get maklumat akses without decrypting password (for listings)
    */
    public function getMaklumatAksesSafe()
    {
        if (empty($this->attributes['maklumat_akses'])) {
            return null;
        }
        
        $data = json_decode($this->attributes['maklumat_akses'], true);
        
        if (!is_array($data)) {
            return null;
        }

        // Multiple entries
        if (isset($data[0]) && is_array($data[0])) {
            $safeArray = [];
            foreach ($data as $entry) {
                if (is_array($entry) && isset($entry['kata_laluan'])) {
                    $entry['kata_laluan'] = '********';
                }
                $safeArray[] = $entry;
            }
            return $safeArray;
        } 
        // Single entry
        else {
            if (isset($data['kata_laluan'])) {
                $data['kata_laluan'] = '********';
            }
            return [$data];
        }
    }

    /**
    * Get only the decrypted password (for admin view)
    */
    public function getDecryptedPassword()
    {
        if (empty($this->maklumat_akses)) {
            return null;
        }
        
        // If single entry in array format
        if (count($this->maklumat_akses) === 1) {
            return $this->maklumat_akses[0]['kata_laluan'] ?? null;
        }
        
        // Multiple entries - return array of passwords
        $passwords = [];
        foreach ($this->maklumat_akses as $entry) {
            $passwords[] = $entry['kata_laluan'] ?? null;
        }
        return $passwords;
    }

    /**
    * Check if maklumat akses has been entered
    */
    public function hasMaklumatAkses(): bool
    {
        return !empty($this->attributes['maklumat_akses']);
    }

    /**
     * Check if a specific Pentadbir Sistem (User ID) has entered any maklumat akses data
     */
    public function hasPentadbirEnteredData($userId): bool
    {
        $akses = $this->maklumat_akses;
        if (empty($akses) || !is_array($akses)) {
            return false;
        }

        foreach ($akses as $key => $value) {
            // Check if this is a direct entry (has 'entered_by' key)
            if (is_array($value) && isset($value['entered_by'])) {
                if ((string)$value['entered_by'] === (string)$userId) {
                    return true;
                }
            } 
            // Check if this is a category/list of entries
            elseif (is_array($value)) {
                foreach ($value as $subValue) {
                    if (is_array($subValue) && isset($subValue['entered_by'])) {
                        if ((string)$subValue['entered_by'] === (string)$userId) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
    * Get count of maklumat akses entries
    */
    public function getMaklumatAksesCount(): int
    {
        if (!$this->hasMaklumatAkses()) {
            return 0;
        }
        
        $akses = $this->maklumat_akses;
        if (empty($akses) || !is_array($akses)) {
            return 0;
        }
        
        return count($akses);
    }

    /**
    * Get required fields based on kategori
    */
    public function getRequiredFieldsForKategori(): array
    {
        switch ($this->kategori) {
            case self::KATEGORI_SERVER:
            case self::KATEGORI_SISTEM_APLIKASI:
                return ['id_pengguna', 'kata_laluan', 'kumpulan_capaian'];
            
            case self::KATEGORI_EMEL:
                return ['id_emel', 'kata_laluan'];
            
            default:
                return [];
        }
    }

    /**
    * Validate maklumat akses structure based on kategori
    */
    public function validateMaklumatAkses(array $data): bool
    {
        if (empty($data) || !is_array($data)) {
            return false;
        }

        $requiredFields = $this->getRequiredFieldsForKategori();
        
        // If it's array of entries
        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $entry) {
                foreach ($requiredFields as $field) {
                    if (empty($entry[$field])) {
                        return false;
                    }
                }
            }
        } 
        // Single entry
        else {
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return false;
                }
            }
        }
        
        return true;
    }

    /**
    * Get validation rules for maklumat akses based on kategori
    */
    public function getMaklumatAksesValidationRules(): array
    {
        switch ($this->kategori) {
            case self::KATEGORI_SERVER:
            case self::KATEGORI_SISTEM_APLIKASI:
                return [
                    'maklumat_akses' => 'required|array|min:1',
                    'maklumat_akses.*.id_pengguna' => 'required|string|max:255',
                    'maklumat_akses.*.kata_laluan' => 'required|string|min:8|max:255',
                    'maklumat_akses.*.kumpulan_capaian' => 'required|string|max:255',
                ];
            
            case self::KATEGORI_EMEL:
                return [
                    'maklumat_akses' => 'required|array|min:1',
                    'maklumat_akses.*.id_emel' => 'required|email|max:255',
                    'maklumat_akses.*.kata_laluan' => 'required|string|min:8|max:255',
                ];
            
            default:
                return [];
        }
    }

    /**
     * Check if application is fully approved by all parties
     */
    public function isFullyApproved(): bool
    {
        return $this->status_pengarah === self::STATUS_DILULUSKAN 
            && $this->status_pegawai === self::STATUS_DILULUSKAN
            && $this->status_pentadbir_sistem === self::STATUS_LULUS;
    }

    /**
     * Check if application is ready for maklumat akses input
     */
    public function isReadyForMaklumatAkses(): bool
    {
        return $this->status_pentadbir_sistem === self::STATUS_LULUS 
            && !$this->hasMaklumatAkses();
    }

    /**
     * Calculates and sets the overall status_permohonan based on stage statuses
     */
    public function determineOverallStatus(): void
    {
        $pengarah = $this->status_pengarah;
        $pegawai  = $this->status_pegawai;
        $pentadbir = $this->status_pentadbir_sistem;
        
        $newStatus = self::STATUS_DALAM_PROSES;

        // Priority 1: Check untuk Ditolak
        if ($pengarah === self::STATUS_DITOLAK || 
            $pegawai === self::STATUS_DITOLAK || 
            $pentadbir === self::STATUS_DITOLAK ||
            $pengarah === self::STATUS_TOLAK || 
            $pegawai === self::STATUS_TOLAK || 
            $pentadbir === self::STATUS_TOLAK) {
            $newStatus = self::STATUS_DITOLAK;
        }
        // Priority 2: Check untuk KIV
        else if ($pengarah === self::STATUS_KIV || 
                $pegawai === self::STATUS_KIV || 
                $pentadbir === self::STATUS_KIV) {
            $newStatus = self::STATUS_KIV;
        }
        // Priority 3: Check berapa peranan yang diperlukan dan berapa yang dah lulus
        else {
            $requiredRoles = $this->getRequiredApprovalRoles(); // Method baru
            $approvedCount = 0;
            $totalRequired = count($requiredRoles);
            
            foreach ($requiredRoles as $role) {
                $status = null;
                
                if ($role === 'Pengarah') {
                    $status = $pengarah;
                } else if ($role === 'Pegawai') {
                    $status = $pegawai;
                } else if ($role === 'Pentadbir Sistem') {
                    $status = $pentadbir;
                }
                
                if ($status === self::STATUS_LULUS || $status === self::STATUS_DILULUSKAN) {
                    $approvedCount++;
                }
            }
            
            // Jika semua peranan yang diperlukan dah lulus
            if ($approvedCount === $totalRequired && $totalRequired > 0) {
                // ✅ Semua peranan telah lulus
                // Status kekal "Dalam Proses" selagi maklumat akses untuk SEMUA kategori belum lengkap
                if ($this->hasMaklumatAksesForAllCategories()) {
                    $newStatus = self::STATUS_SELESAI;
                } else {
                    $newStatus = self::STATUS_DALAM_PROSES;
                }
            }
            // Jika ada yang lulus tapi belum semua
            else if ($approvedCount > 0) {
                $newStatus = self::STATUS_DALAM_PROSES;
            }
        }

        if ($this->status_permohonan !== $newStatus) {
            $this->status_permohonan = $newStatus;
        }
    }

    /**
     * Get required approval roles based on kategori or other criteria
     */
    private function getRequiredApprovalRoles(): array
    {
        $roles = ['Pengarah', 'Pegawai', 'Pentadbir Sistem'];
        return $roles;
    }

    /**
     * Check if maklumat_akses has been filled for ALL applied categories
     * (digunakan untuk tentukan bila status_permohonan boleh jadi "Selesai")
     */
    public function hasMaklumatAksesForAllCategories(): bool
    {
        $kategoriList = $this->kategori;

        if (empty($kategoriList)) {
            return false;
        }

        if (!is_array($kategoriList)) {
            $kategoriList = [$kategoriList];
        }

        $akses = $this->maklumat_akses;

        if (empty($akses) || !is_array($akses)) {
            return false;
        }

        foreach ($kategoriList as $kategoriNama) {
            if (empty($kategoriNama)) {
                continue;
            }

            if (!isset($akses[$kategoriNama]) || !is_array($akses[$kategoriNama])) {
                return false;
            }

            // Pastikan sekurang-kurangnya satu rekod tidak kosong untuk kategori ini
            $nonEmptyEntries = array_filter($akses[$kategoriNama], function ($entry) {
                return is_array($entry) && !empty(array_filter($entry));
            });

            if (count($nonEmptyEntries) === 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get list of categories that are still missing maklumat_akses
     * Returns array of category names | empty array if all complete
     */
    public function getIncompleteMaklumatAksesCategories(): array
    {
        $kategoriList = $this->kategori;

        if (empty($kategoriList)) {
            return [];
        }

        if (!is_array($kategoriList)) {
            $kategoriList = [$kategoriList];
        }

        $akses = $this->maklumat_akses;
        $incompleteCategories = [];

        foreach ($kategoriList as $kategoriNama) {
            if (empty($kategoriNama)) {
                continue;
            }

            // Check if this category has no access info OR has empty access info
            if (!isset($akses[$kategoriNama]) || !is_array($akses[$kategoriNama])) {
                $incompleteCategories[] = $kategoriNama;
                continue;
            }

            // Check if all entries for this category are empty
            $nonEmptyEntries = array_filter($akses[$kategoriNama], function ($entry) {
                return is_array($entry) && !empty(array_filter($entry));
            });

            if (count($nonEmptyEntries) === 0) {
                $incompleteCategories[] = $kategoriNama;
            }
        }

        return $incompleteCategories;
    }


    public function scopeLulus($query)
    {
        return $query->where('status_pegawai', self::STATUS_DILULUSKAN);
    }

    public function scopeDitolak($query)
    {
        return $query->where('status_pegawai', self::STATUS_DITOLAK);
    }

    public function scopeKiv($query)
    {
        return $query->where('status_pegawai', self::STATUS_KIV);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status_permohonan', self::STATUS_SELESAI);
    }

    public function scopeDalamProses($query)
    {
        return $query->where('status_permohonan', self::STATUS_DALAM_PROSES);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('tarikh_hantar', '>=', now()->subDays($days));
    }

    public function scopeLulusPentadbirSistem($query)
    {
        return $query->where('status_pentadbir_sistem', self::STATUS_LULUS);
    }

    public function scopeDitolakPentadbirSistem($query)
    {
        return $query->where('status_pentadbir_sistem', self::STATUS_TOLAK);
    }

    public function scopeKivPentadbirSistem($query)
    {
        return $query->where('status_pentadbir_sistem', self::STATUS_KIV);
    }

    public function scopeMenungguMaklumatAkses($query)
    {
        return $query->where('status_pentadbir_sistem', self::STATUS_LULUS)
                     ->whereNull('maklumat_akses');
    }

    public function scopeWithMaklumatAkses($query)
    {
        return $query->whereNotNull('maklumat_akses');
    }

    public function scopeByApplicant($query, $noKp)
    {
        return $query->where('no_kp', $noKp);
    }

    /**
     * Get available jenis permohonan options
     */
    public static function getJenisPermohonanOptions(): array
    {
        return [
            self::JENIS_PENDAFTARAN_BARU,
            self::JENIS_KEMASKINI,
            self::JENIS_PENAMATAN,
        ];
    }
}