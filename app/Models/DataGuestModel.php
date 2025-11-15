<?php

namespace App\Models;

use CodeIgniter\Model;

class DataGuestModel extends Model
{
    protected $table = 'data_guest';
    protected $primaryKey = 'id_guest';
    protected $allowedFields = ['email_guest', 'nama_guest', 'jenis_motor', 'merek_motor'];
}
