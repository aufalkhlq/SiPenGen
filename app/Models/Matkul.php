<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    protected $table = 'matkul';
    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'sks'
    ];

    public function pengampu()
    {
        return $this->hasMany(Pengampu::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
