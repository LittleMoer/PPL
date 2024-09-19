<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class Info_skripsi extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'info_skripsis';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = 'nim';

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'nim', 
        'semester',
        'nilai_skripsi',
        'tgl_lulus',
        'lama_study',
        'scan_skripsi',
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>