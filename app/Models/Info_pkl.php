<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class Info_pkl extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'info_pkls';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = 'nim';

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'nim', 
        'semester',
        'nilai_pkl',
        'scan_pkl',
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>