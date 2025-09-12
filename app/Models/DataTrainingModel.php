<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTrainingModel extends Model
{
    protected $table      = 'data_training';   // nama tabel
    protected $primaryKey = 'id_training';

    protected $allowedFields = ['gejala', 'kelas', 'solusi'];
}
