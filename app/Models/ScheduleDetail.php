<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;

    protected $table = 'schedule_detail';

    protected $primaryKey = 'id_schedule_detail'; // Specify the primary key

    protected $fillable = [
        'id_schedule',
        'id_user',
    ];

    public function game()
    {
        return $this->hasOne(Game::class, 'id_schedule_detail', 'id_schedule_detail');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
