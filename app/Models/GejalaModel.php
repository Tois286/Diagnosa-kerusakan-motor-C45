<?php

namespace App\Models;

use CodeIgniter\Model;

class GejalaModel extends Model
{
    protected $table      = 'gejala';       // nama tabel
    protected $primaryKey = 'id_gejala';           // primary key
    protected $allowedFields = ['nama_gejala', 'kode_gejala']; // kolom yang boleh diisi
}
