<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kritik extends Model
{
    use HasFactory;

    protected $table = 'kritiks'; // Nama tabel
    protected $primaryKey = 'id_kritik'; // Nama kolom primary key

    protected $fillable = [
        'user_id',
        'date',
        'comment',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relasi dengan tabel users
    }
}
