<?php

namespace App\Controllers;

use App\Models\DataTrainingModel;
use App\Models\GejalaModel;
use App\Models\KerusakanModel;
use App\Libraries\C45;
use App\Models\DataGuestModel;

class DiagnosaController extends BaseController
{
    protected $gejalaModel;
    protected $dataTrainingModel;
    protected $kerusakanModel;

    public function __construct()
    {
        $this->gejalaModel = new GejalaModel();
        $this->dataTrainingModel = new DataTrainingModel();
        $this->kerusakanModel = new KerusakanModel();
    }

    public function index()
    {
        $data['gejala'] = $this->gejalaModel->findAll();
        return view('diagnosa/form', $data);
    }

    public function proses()
    {
        $gejalaTerpilih = $this->request->getPost('gejala');

        if (empty($gejalaTerpilih)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu gejala.');
        }

        // Ambil semua data training
        $dataset = $this->dataTrainingModel->findAll();

        // Buat instance C45
        $c45 = new C45($dataset);
        $tree = $c45->buildTree();
        $trace = $c45->getTrace();

        // Siapkan input sesuai atribut dataset
        $allAttributes = array_keys($dataset[0]);
        $allAttributes = array_filter($allAttributes, fn($a) => !in_array($a, ['id_training', 'hasil']));

        $input = [];
        foreach ($allAttributes as $attr) {
            $input[$attr] = in_array($attr, $gejalaTerpilih) ? 1 : 0;
        }

        // Prediksi hasil
        $hasilPrediksi = $c45->diagnosa($input, $tree);

        // Ambil detail kerusakan
        $hasilKerusakan = $this->kerusakanModel
            ->where('kode_kerusakan', $hasilPrediksi)
            ->first();

        // Ambil nama gejala terpilih
        $gejalaList = $this->gejalaModel->findAll();
        $mapGejala = array_column($gejalaList, 'nama_gejala', 'kode_gejala');
        $namaGejalaTerpilih = array_map(fn($g) => $mapGejala[$g] ?? $g, $gejalaTerpilih);

        // Evaluasi
        $evaluasi = $c45->evaluate($dataset, $tree);

        // Simpan ke session
        session()->set([
            'tree'           => $tree,             // pohon keputusan
            'trace'          => $trace,            // perhitungan entropy & gain
            'gejalaTerpilih' => $namaGejalaTerpilih,
            'hasil'          => $hasilKerusakan,   // hasil diagnosa
            'evaluasi'       => $evaluasi          // akurasi
        ]);

        $gejalaTerpilih = $this->request->getPost('gejala');

        if (empty($gejalaTerpilih)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu gejala.');
        }
        // Redirect sesuai role
        $role = session()->get('role');
        if ($role === 'admin') {
            return redirect()->to('/content/admin/index?tab=HasilDiagnosa');
        } elseif ($role === 'karyawan') {
            return redirect()->to('/content/index?tab=HasilDiagnosa');
        }

        return redirect()->to('/diagnosa');
    }

    public function check()
    {
        $DiagnosaGuest = new DataGuestModel();
        $session       = session();

        $check = [
            'email_guest' => $this->request->getPost('email'),
            'nama_guest' => $this->request->getPost('nama'),
            'jenis_motor' => $this->request->getPost('jenis'),
            'merek_motor' => $this->request->getPost('merek'),
        ];

        $gejalaTerpilih = $this->request->getPost('gejala');

        if (empty($gejalaTerpilih)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu gejala.');
        }

        // Ambil semua data training
        $dataset = $this->dataTrainingModel->findAll();

        // Buat instance C45
        $c45 = new C45($dataset);
        $tree = $c45->buildTree();
        $trace = $c45->getTrace();

        // Siapkan input sesuai atribut dataset
        $allAttributes = array_keys($dataset[0]);
        $allAttributes = array_filter($allAttributes, fn($a) => !in_array($a, ['id_training', 'hasil']));

        $input = [];
        foreach ($allAttributes as $attr) {
            $input[$attr] = in_array($attr, $gejalaTerpilih) ? 1 : 0;
        }

        // Prediksi hasil
        $hasilPrediksi = $c45->diagnosa($input, $tree);

        // Ambil detail kerusakan
        $hasilKerusakan = $this->kerusakanModel
            ->where('kode_kerusakan', $hasilPrediksi)
            ->first();

        // Ambil nama gejala terpilih
        $gejalaList = $this->gejalaModel->findAll();
        $mapGejala = array_column($gejalaList, 'nama_gejala', 'kode_gejala');
        $namaGejalaTerpilih = array_map(fn($g) => $mapGejala[$g] ?? $g, $gejalaTerpilih);

        // Evaluasi
        $evaluasi = $c45->evaluate($dataset, $tree);

        // Simpan ke session
        session()->set([
            'tree'           => $tree,             // pohon keputusan
            'trace'          => $trace,            // perhitungan entropy & gain
            'gejalaTerpilih' => $namaGejalaTerpilih,
            'hasil'          => $hasilKerusakan,   // hasil diagnosa
            'evaluasi'       => $evaluasi          // akurasi
        ]);

        $gejalaTerpilih = $this->request->getPost('gejala');

        if (empty($gejalaTerpilih)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu gejala.');
        }

        $DiagnosaGuest->insert($check);
        $session->setFlashdata('success', 'Pengecekan berhasil dilakukan');
        return redirect()->back()->with('showResult', true);
    }
}
