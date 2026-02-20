<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktiviti extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitis';
    protected $primaryKey = 'id_log';
    public $timestamps = true; // 

    protected $fillable = [
        'id_user',
        'tindakan',
        'tarikh_aktiviti',
    ];

    protected $casts = [
        'tarikh_aktiviti' => 'datetime',
    ];

    // 🔹 Relationship: Log belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
