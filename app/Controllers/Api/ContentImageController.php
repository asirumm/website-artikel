<?php

namespace App\Controllers\Api;

use App\ApplicationConfiguration\MonologConfig;
use App\Helpers\FileHelper;
use App\Helpers\RandomString;
use CodeIgniter\RESTful\ResourceController;
use Monolog\Logger;

/**
 * Handle file image upload dari konten blog
*/
class ContentImageController extends ResourceController
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = MonologConfig::getApplicationLogger();
    }


    public function create()
    {
        // dari form post api
        $file = $this->request->getFile("content-image");

        $fileName = RandomString::randomString(10);
        $fileName = $fileName.".".$file->getClientExtension();

        $result = FileHelper::save($file,FileHelper::$ARTICLE_CONTENT_IMAGE,$fileName);

        if ($result==null){
            $this->logger->warning("upload image content gagal");

            return $this->respond(["url"=>null,"message"=>"gagal upload ada kesalahan server"],500);
        }

        $url = base_url("article/content-image/{$fileName}");
        return $this->respond(["url"=>$url,"message"=>"sukses upload file"],201);
    }
}
