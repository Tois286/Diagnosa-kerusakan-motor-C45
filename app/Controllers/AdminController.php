<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }
        $gejalaModel = new \App\Models\GejalaModel();
        $data['gejala'] = $gejalaModel->findAll();

        $kerusakanModel = new \App\Models\KerusakanModel();
        $data['kerusakan'] = $kerusakanModel->findAll();

        return view('content/admin/index', $data);
    }
}
