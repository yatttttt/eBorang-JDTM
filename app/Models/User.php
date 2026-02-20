<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use App\Models\LogAktiviti;
use App\Models\Ulasan;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'email',
        'kata_laluan',
        'peranan',
        'gambar_profil',
        'tandatangan',  
    ];

    protected $hidden = [
        'kata_laluan',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Appended attributes
    protected $appends = ['gambar_profil_url', 'initial', 'jawatan'];

    public function getAuthPassword()
    {
        return $this->kata_laluan;
    }

    // Relationships
    public function logAktiviti()
    {
        return $this->hasMany(LogAktiviti::class, 'id_user', 'id_user');
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'id_user_pengulas', 'id_user');
    }

    // Accessor untuk name attribute (untuk compatibility dengan PDF)
    public function getNameAttribute()
    {
        return $this->nama;
    }

    // Accessor untuk jawatan berdasarkan peranan (untuk PDF)
    public function getJawatanAttribute()
    {
        $jawatanMap = [
            'admin' => 'Pentadbir',
            'pegawai' => 'Pegawai Teknologi Maklumat',
            'pentadbir_sistem' => 'Pentadbir Sistem',
            'pengarah' => 'Pengarah Bahagian Teknologi Maklumat',
        ];

        return $jawatanMap[$this->peranan] ?? ucfirst($this->peranan);
    }

    // Get formatted role name
    public function getPerananFormattedAttribute()
    {
        $roles = [
            'admin' => 'Admin',
            'pegawai' => 'Pegawai',
            'pentadbir_sistem' => 'Pentadbir Sistem',
            'pengarah' => 'Pengarah',
        ];

        return $roles[$this->peranan] ?? ucfirst($this->peranan ?? 'User');
    }

    // Get profile photo URL
    public function getGambarProfilUrlAttribute()
    {
        if ($this->gambar_profil && Storage::disk('public')->exists($this->gambar_profil)) {
            return Storage::url($this->gambar_profil);
        }

        return null;
    }

    // Get user's initial letter
    public function getInitialAttribute()
    {
        return strtoupper(substr($this->nama ?? 'U', 0, 1));
    }

    // Update profile photo
    public function updateGambarProfil($file)
    {
        // Delete old photo if exists
        if ($this->gambar_profil && Storage::disk('public')->exists($this->gambar_profil)) {
            Storage::disk('public')->delete($this->gambar_profil);
        }

        // Store new photo
        $path = $file->store('profile-photos', 'public');
        
        $this->update(['gambar_profil' => $path]);

        return $path;
    }

    // Delete profile photo
    public function deleteGambarProfil()
    {
        if ($this->gambar_profil && Storage::disk('public')->exists($this->gambar_profil)) {
            Storage::disk('public')->delete($this->gambar_profil);
            $this->update(['gambar_profil' => null]);
            return true;
        }

        return false;
    }

    // Get signature URL 
    public function getTandatanganUrlAttribute()
    {
        // Access raw attribute directly to avoid potential recursion
        $tandatangan = $this->attributes['tandatangan'] ?? null;
        
        if ($tandatangan && Storage::disk('public')->exists('signatures/' . $tandatangan)) {
            return Storage::url('signatures/' . $tandatangan);
        }
        
        return null;
    }

    // Update signature
    public function updateTandatangan($file)
    {
        // Delete old signature if exists
        $oldSignature = $this->attributes['tandatangan'] ?? null;
        
        if ($oldSignature && Storage::disk('public')->exists('signatures/' . $oldSignature)) {
            Storage::disk('public')->delete('signatures/' . $oldSignature);
        }

        // Store new signature in 'signatures' folder
        $filename = 'signature_' . $this->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('signatures', $filename, 'public');
        
        $this->update(['tandatangan' => $filename]);

        return $filename;
    }

    // Delete signature
    public function deleteTandatangan()
    {
        $tandatangan = $this->attributes['tandatangan'] ?? null;
        
        if ($tandatangan && Storage::disk('public')->exists('signatures/' . $tandatangan)) {
            Storage::disk('public')->delete('signatures/' . $tandatangan);
            $this->update(['tandatangan' => null]);
            return true;
        }

        return false;
    }
}