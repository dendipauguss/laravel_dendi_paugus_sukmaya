<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $fillable = ['nama_pasien', 'alamat', 'no_telpon', 'rumah_sakit_id'];

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class, 'rumah_sakit_id');
    }
}
