<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules'; // Table name

    protected $primaryKey = 'id_schedule'; // Primary key column name

    public $timestamps = true; // Enables created_at and updated_at columns

    protected $fillable = ['activity_name', 'date', 'time'];
}
