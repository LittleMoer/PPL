<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class Info_khs extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'info_khs';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = ['nim','smt'];

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'nimn', 
        'smt',
        'sks',
        'sks_kumulatif',
        'ip_smt',
        'scan_irs',
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>