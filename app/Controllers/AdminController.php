<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $trainingModel = new \App\Models\DataTrainingModel();
        $data['training'] = $trainingModel->findAll();

        // $testingModel = new \App\Models\DataTestingModel();
        // $data['testing'] = $testingModel->findAll();

        $gejalaModel = new \App\Models\GejalaModel();
        $data['gejala'] = $gejalaModel->findAll();
        $data['total_gejala'] = count($data['gejala']);

        $kerusakanModel = new \App\Models\KerusakanModel();
        $data['kerusakan'] = $kerusakanModel->findAll();
        $data['total_kerusakan'] = count($data['kerusakan']);

        $dataUserModel = new \App\Models\DataUsersModel();
        $data['karyawan'] = $dataUserModel->findAll();
        $data['total_karyawan'] = count($data['karyawan']);

        $userModel = new \App\Models\UserModel();

        // ambil semua user
        $data['users'] = $userModel->getUser();

        //ambil data guest
        $guestModel = new \App\Models\DataGuestModel();
        $data['guest'] = $guestModel->findAll();
        $data['total_guest'] = count($data['guest']);


        // ambil user login saja (berdasarkan session)
        $idUser = session()->get('id_user');
        $data['sesUser'] = $userModel->getUser($idUser);

        // kalau mau filter status langsung dari controller:
        $data['karyawan'] = $userModel->getUser(null, 'karyawan');
        $data['admin'] = $userModel->getUser(null, 'admin');
        // $data['pelanggan'] = $userModel->getUser(null, 'pelanggan');

        return view('content/admin/index', $data);
    }
}
