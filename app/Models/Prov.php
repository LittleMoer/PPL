<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class Prov extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'prov';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = 'id_prov';

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'id_prov', 
        'provinsi',
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>