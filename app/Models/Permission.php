<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    use HasFactory;
    
    protected $table = 'permission';
    protected $fillable = ['id','name','guard_name','created_at','updated_at'];
}