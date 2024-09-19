<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class Operator extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'operators';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = 'nip';

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'nip', 
        'nama'
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>