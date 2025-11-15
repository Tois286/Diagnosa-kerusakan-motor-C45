<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTestingModel extends Model
{
    protected $table      = 'data_testing';   // nama tabel
    protected $primaryKey = 'id_testing';

    protected $allowedFields = [
        'G1',
        'G2',
        'G3',
        'G4',
        'G5',
        'G6',
        'G7',
        'G8',
        'G9',
        'G10',
        'G11',
        'G12',
        'G13',
        'G14',
        'G15',
        'G16',
        'G17',
        'G18',
        'G19',
        'G20',
        'hasil'
    ];
}
