<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = [
        'nip_dosen', 
        'nama_dosen', 
        'notelp_dosen', 
        'email_dosen'
    ];
    use HasFactory;
}