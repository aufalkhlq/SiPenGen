<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    protected $fillable = [
        'nama_mahasiswa',
        'nim',
        'kelas_id',
        'prodi',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'nim';
    }

    public function getAuthIdentifier()
    {
        return $this->nim;
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

}

