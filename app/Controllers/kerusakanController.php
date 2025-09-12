<?php

namespace App\Controllers;

use App\Models\KerusakanModel;

class KerusakanController extends BaseController
{
    public function index()
    {
        return redirect()->to('/content/admin/index?tab=Kerusakan')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function save()
    {
        $KerusakanModel = new KerusakanModel();

        $data = [
            'nama_kerusakan' => $this->request->getPost('nama_kerusakan'),
            'kode_kerusakan'  => $this->request->getPost('kode_kerusakan'),
            'solusi_kerusakan' => $this->request->getPost('solusi_kerusakan')
        ];

        $KerusakanModel->insert($data);

        return redirect()->to('/kerusakan')->with('success', 'Data berhasil ditambahkan');
    }
}
