<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'tahun_angkatan', 'prodi'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
