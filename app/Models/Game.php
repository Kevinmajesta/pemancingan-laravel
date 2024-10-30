<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'game';
    protected $primaryKey = 'id_game';
    public $timestamps = false;

    protected $fillable = [
        'id_schedule_detail',
        'id_schedule',
        'id_user', // Pastikan nama ini konsisten dengan nama kolom di database
        'ikanterberat_sesi1',
        'ikanterberat_sesi2',
        'ikanterbanyak',
        'pemenang',
        'date', // Tambahkan date jika ingin mass assign
    ];

    public function scheduleDetail()
    {
        return $this->belongsTo(ScheduleDetail::class, 'id_schedule_detail');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // Ganti 'user_id' dengan 'id_user'
    }
    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_schedule'); // Menambahkan relasi ke schedules
    }
}
