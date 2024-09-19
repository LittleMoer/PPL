<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Membuat kelas Book
class Account extends Model
{
    // Menentukan nama tabel referensi dari PHP MyAdmin
    protected $tabel = 'accounts';

    // Menentukan Primary Key pada tabel
    protected $primaryKey = 'nim_nip';

    // Menentukan kolom yang dapat diisi pada tabel
    protected $fillable = [
        'email', 
        'nim_nip', 
        'password',
        'role'
    ] ;

    public $incrementing = false;
    public $timestamps = false;    
}

?>