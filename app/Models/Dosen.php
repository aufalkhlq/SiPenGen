<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Dosen extends Authenticatable
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'nama_dosen', 'nip', 'prodi', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'nip';
    }

    public function getAuthIdentifier()
    {
        return $this->nip;
    }
    public function pengampu()
    {
        return $this->hasMany(Pengampu::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }




}
