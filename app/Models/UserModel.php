<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        "user_id","email","username","password","role"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;


    // Validation
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $validationRules      = [
        'username' => [
            'rules'  => 'required|min_length[3]|max_length[30]|alpha_numeric',
            'errors' => [
                'required'   => 'username wajib diisi.',
                'min_length' => 'username minimal 3 karakter.',
                'max_length' => 'username maksimal 30 karakter.',
                'alpha_numeric' => 'username hanya boleh huruf dan angka.'
            ]
        ],
        'email' => [
            'rules'  => 'required|valid_email|is_unique[user.email]',
            'errors' => [
                'required'    => 'email wajib diisi.',
                'valid_email' => 'format email tidak valid.',
                'is_unique'   => 'email sudah terdaftar.'
            ]
        ],
        'password' => [
            'rules'  => 'required|min_length[6]',
            'errors' => [
                'required'   => 'password wajib diisi.',
                'min_length' => 'password minimal 6 karakter.'
            ]
        ]
    ];


    // Callbacks
    protected $allowCallbacks = true;
//    method yang akan dipanggil sebelum insert
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function hashPassword($user)
    {
        // kenapa $user['data']['password'] karena semua data value ada pada array ['data']
        // {"data":{"user_id":"b14f4f155fb17e3cd4",
        //"email":"target@gmail.com",
        //"username":"examplesx",
        //"password":"example",
        //"role":"ADMIN"}}
        if (isset($user['data']['password'])){
            $user['data']['password'] = password_hash($user['data']['password'],PASSWORD_BCRYPT);
        }
        return $user;
    }


}
