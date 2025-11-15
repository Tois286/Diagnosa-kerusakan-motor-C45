<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['email', 'password', 'role'];

    public function getUser($idUser = null, $role = null)
    {
        $builder = $this->db->table('user u')
            ->select('u.id_user, u.email, u.role, d.id_dataUser, d.nama_user, d.t_tinggal, d.tgl_lahir, d.status_pengguna')
            ->join('data_user d', 'd.id_user = u.id_user', 'left');

        // filter berdasarkan id_user (misalnya untuk session login)
        if ($idUser !== null) {
            $builder->where('u.id_user', $idUser);
        }

        // filter berdasarkan role user
        if ($role !== null) {
            $builder->where('u.role', $role);
        }

        return $builder->get()->getResultArray();
    }
}
