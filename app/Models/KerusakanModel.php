<?php

namespace App\Models;

use CodeIgniter\Model;

class KerusakanModel extends Model
{
    protected $table = 'kerusakan';
    protected $primaryKey = 'id_kerusakan';
    protected $allowedFields = ['kode_kerusakan', 'nama_kerusakan', 'solusi'];
}
