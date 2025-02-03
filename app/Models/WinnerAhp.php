<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnerAhp extends Model
{
    use HasFactory;

    // Specify the custom table name if needed
    protected $table = 'winner_ahp';

    // Specify the custom primary key
    protected $primaryKey = 'id_winner_ahp'; // Custom primary key

    // If your primary key is auto-incrementing, make sure to set this to true
    public $incrementing = true;

    // Set the key type to 'int', which is the default type for an auto-incrementing key
    protected $keyType = 'int';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'month',
        'year',
        'id_user',
        'score',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

