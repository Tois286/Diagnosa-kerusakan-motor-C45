<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $gejalaModel = new \App\Models\GejalaModel();
        $data['gejala'] = $gejalaModel->findAll();
        return view('login', $data);
    }
}
