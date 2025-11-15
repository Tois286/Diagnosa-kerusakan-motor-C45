<?php

namespace App\Controllers;

class UsersController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'karyawan') {
            return redirect()->to('/auth/login');
        }

        $gejalaModel = new \App\Models\GejalaModel();
        $data['gejala'] = $gejalaModel->findAll();

        $kerusakanModel = new \App\Models\KerusakanModel();
        $data['kerusakan'] = $kerusakanModel->findAll();

        $userModel = new \App\Models\UserModel();

        // ambil semua user
        $data['users'] = $userModel->getUser();

        // ambil user login saja (berdasarkan session)
        $idUser = session()->get('id_user');
        $data['sesUser'] = $userModel->getUser($idUser);

        // kalau mau filter status langsung dari controller:
        $data['karyawan'] = $userModel->getUser(null, 'karyawan');
        $data['admin'] = $userModel->getUser(null, 'admin');
        $data['pelanggan'] = $userModel->getUser(null, 'pelanggan');

        return view('content/index', $data);
    }
}
