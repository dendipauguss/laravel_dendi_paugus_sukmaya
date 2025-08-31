<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    protected $table = 'rumah_sakit';
    protected $fillable = ['nama_rumah_sakit', 'alamat', 'email', 'telepon'];

    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'rumah_sakit_id');
    }
}
