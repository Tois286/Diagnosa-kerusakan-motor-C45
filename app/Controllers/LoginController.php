<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DataUsersModel;
use App\Models\GejalaModel;

class LoginController extends BaseController
{
    public function login()
    {
        
        return view('/auth/login');
    }

    public function loginProcess()
    {
        $session   = session();
        $userModel = new UserModel();

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Verifikasi password dengan hash di database
            if (password_verify($password, $user['password'])) {
                // Buat data session
                $sessionData = [
                    'id_user'   => $user['id_user'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'logged_in' => true,
                ];
                $session->set($sessionData);

                // Redirect sesuai role
                switch ($user['role']) {
                    case 'admin':
                        return redirect()->to('/content/admin/index');
                    case 'karyawan':
                        return redirect()->to('/content/index');
                    default:
                        return redirect()->to('/content/index');
                }
            } else {
                $session->setFlashdata('error', 'Password salah');
                return redirect()->to('/auth/login');
            }
        } else {
            $session->setFlashdata('error', 'Email tidak ditemukan');
            return redirect()->to('/auth/login');
        }
    }

    public function regist()
    {
        $DataUserModel = new DataUsersModel();
        $UserModel     = new UserModel();
        $session       = session();

        // Simpan ke tabel user dulu
        $data2 = [
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('status_pengguna'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $UserModel->insert($data2);

        // Ambil id_user terakhir dari insert di UserModel
        $id_user = $UserModel->insertID();

        // Baru simpan ke tabel data_users dengan relasi id_user
        $data1 = [
            'nama_user'      => $this->request->getPost('nama'),
            'status_pengguna' => $this->request->getPost('status_pengguna'),
            't_tinggal'      => $this->request->getPost('t_tinggal'),
            'tgl_lahir'      => $this->request->getPost('tgl_lahir'),
            'id_user'        => $id_user
        ];

        $DataUserModel->insert($data1);

        // Beri pesan sukses
        $session->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
