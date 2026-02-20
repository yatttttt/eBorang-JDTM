<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ulasans';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_ulasan';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_permohonan',
        'id_user_pengulas',
        'peranan_pengulas',
        'ulasan',
        'status',
        'tarikh_ulasan',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'tarikh_ulasan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship back to Permohonan
     */
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id_permohonan');
    }

    /**
     * Relationship to User (pengulas/reviewer)
     */
    public function pengulas()
    {
        return $this->belongsTo(User::class, 'id_user_pengulas', 'id_user');
    }

    /**
     * Scope for pengarah comments
     */
    public function scopePengarah($query)
    {
        return $query->where('peranan_pengulas', 'pengarah');
    }

    /**
     * Scope for pegawai comments
     */
    public function scopePegawai($query)
    {
        return $query->where('peranan_pengulas', 'pegawai');
    }

    /**
     * Scope for comments by specific status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for recent comments
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('tarikh_ulasan', '>=', now()->subDays($days));
    }

    /**
     * Scope for comments by specific user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('id_user_pengulas', $userId);
    }

    /**
     * Scope for comments on specific application
     */
    public function scopeForPermohonan($query, $permohonanId)
    {
        return $query->where('id_permohonan', $permohonanId);
    }

    /**
     * Get formatted reviewer role
     */
    public function getFormattedPerananAttribute()
    {
        return ucfirst($this->peranan_pengulas);
    }

    /**
     * Check if this is a pengarah comment
     */
    public function isPengarah()
    {
        return $this->peranan_pengulas === 'pengarah';
    }

    /**
     * Check if this is a pegawai comment
     */
    public function isPegawai()
    {
        return $this->peranan_pengulas === 'pegawai';
    }
}