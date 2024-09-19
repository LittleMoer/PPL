<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class KabKot extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'kab_kots';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = ['id_kab_kot','id_prov'];

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'id_kab_kot', 
        'id_prov',
        'kab_kot', 
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>