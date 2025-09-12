<?php

namespace App\Controllers;

use App\Models\GejalaModel;

class GejalaController extends BaseController
{
    public function index()
    {
        return redirect()->to('/content/admin/index?tab=Gejala')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function save()
    {
        $gejalaModel = new GejalaModel();

        $data = [
            'nama_gejala' => $this->request->getPost('nama_gejala'),
            'kode_gejala'  => $this->request->getPost('kode_gejala')
        ];

        $gejalaModel->insert($data);

        return redirect()->to('/gejala')->with('success', 'Data berhasil ditambahkan');
    }
}
