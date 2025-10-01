<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table            = 'article';
    protected $primaryKey       = 'article_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "article_id","title","slug","publish_status",
        "date_publish","date_updated","description",
        "file_content","file_thumbnail","user_id"
    ];

    // Validation
    // biarkan ini true kita validasi di controller saja
    // jika anda buat false maka aturan validasi slug dan deskripsi
    // akan menghalangi anda membuat str replace " " menjadi "-"
    // saat insert dan update
    protected $skipValidation       = true;
    protected $cleanValidationRules = false;
    protected $validationRules      = [
        'title' => [
            'rules'  => 'required|min_length[3]|max_length[255]|alpha_numeric_space',
            'errors' => [
                'required'   => 'title wajib diisi.',
                'min_length' => 'title minimal 3 karakter.',
                'max_length' => 'title maksimal 255 karakter.',
                'alpha_numeric_space' => 'title hanya boleh huruf, angka dan spasi.'
            ]
        ],
        'slug' => [
            'rules'  => 'required|min_length[3]|max_length[120]|alpha_numeric_space',
            'errors' => [
                'required'   => 'slug wajib diisi.',
                'min_length' => 'slug minimal 3 karakter.',
                'max_length' => 'slug maksimal 120 karakter.',
                'alpha_numeric_space' => 'slug hanya boleh huruf, angka dan spasi.'
            ]
        ],
        'description' => [
            'rules'  => 'required|min_length[3]|max_length[255]|alpha_numeric_space',
            'errors' => [
                'required'   => 'description wajib diisi.',
                'min_length' => 'description minimal 3 karakter.',
                'max_length' => 'description maksimal 255 karakter.',
                'alpha_numeric_space' => 'description hanya boleh huruf, angka dan spasi.'
            ]
        ]
    ];

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
