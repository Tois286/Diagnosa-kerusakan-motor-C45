<?php

namespace App\Controllers;

use App\Models\DataTestingModel;

class TestingController extends BaseController
{
    public function index()
    {
        return redirect()->to('/content/admin/index?tab=hasil')
            ->with('success', 'Data berhasil ditambahkan');
    }
}
