<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $fillable = ['nama_dosen', 'nip', 'prodi'];
    public function pengampu()
    {
        return $this->hasMany(Pengampu::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    


}
