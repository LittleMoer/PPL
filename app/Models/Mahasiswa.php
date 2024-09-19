<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class Mahasiswa extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'mahasiswas';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = 'nim';

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'nim', 
        'nama',
        'alamat', 
        'kab_kota', 
        'provinsi',
        'angkatan',
        'jalur_masuk',
        'email',
        'no_hp',
        'status',
        'kode_doswal',
        'foto'
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>