<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'kelas_id',
        'pengampu_id',
        'ruangan_id',
        'jam_id',
        'hari_id',
        'fitness'
    ];



    public function pengampu()
    {
        return $this->belongsTo(Pengampu::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function jam()
    {
        return $this->belongsTo(Jam::class);
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }


}
