<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function login()
    {
        return view('/auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Jika password belum di-hash (seperti di contoh), langsung cek sama
            if ($password === $user['password']) {
                $sessionData = [
                    'id_user' => $user['id_user'],
                    'email'   => $user['email'],
                    'role'    => $user['role'],
                    'logged_in' => true,
                ];
                $session->set($sessionData);

                // Redirect sesuai role
                if ($user['role'] === 'admin') {
                    return redirect()->to('/content/admin/index');
                } elseif ($user['role'] === 'karyawan') {
                    return redirect()->to('/content/karyawan/index');
                } else {
                    return redirect()->to('/content/pelanggan/index');
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

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
