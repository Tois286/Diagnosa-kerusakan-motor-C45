<?php

namespace App\Models;

use CodeIgniter\Model;

class DataHistoryModel extends Model
{
    protected $table = 'riwayat_diagnosa';
    protected $primaryKey = 'id_story';
    protected $allowedFields = ['id_dataUser', 'id_guest', 'nama_guest', 'gejala', 'hasil_kerusakan', 'solusi', 'nama_karyawan', 'created_at'];
}
