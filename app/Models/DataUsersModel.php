<?php

namespace App\Models;

use CodeIgniter\Model;

class DataUsersModel extends Model
{
    protected $table = 'data_user';
    protected $primaryKey = 'id_dataUser';
    protected $allowedFields = ['nama_user', 't_tinggal', 'tgl_lahir', 'status_pengguna', 'id_user'];
}
