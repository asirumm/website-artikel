<?php

namespace App\Controllers\Api;

use App\Helpers\RandomString;
use App\Models\ArticleModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Helpers\FileHelper;

class ArticleApiController extends BaseApiController
{
    private ArticleModel $articleModel;

    public function __construct()
    {
        parent::__construct();
        $this->articleModel = new ArticleModel();
    }


    public function index()
    {
        $data = $this->articleModel->findAll();

        foreach ($data as $key => $value) {
            $data[$key]['file_content']   = base_url('article/content-file/' . $value['file_content']);
            $data[$key]['file_thumbnail'] = base_url('article/thumbnail/' . $value['file_thumbnail']);
        }

        return $this->responseSuccess($data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $thumbnail = $this->request->getFile('thumbnail');


        // validasi
        if ( $this->articleModel->validate($data) == false) {
            return $this->responseFailValidationErrors($this->articleModel->errors());
        }


        // generate data essensial
        $data['article_id'] = RandomString::randomString(15);
        $data['slug']       = str_replace(" ","-",$data['slug']);
        $data['slug']       = strtolower($data['slug']);
        $data['date_publish'] = null;
        $data['date_updated'] = null;
        $data['publish_status'] = filter_var($data['publish_status'],FILTER_VALIDATE_BOOLEAN);


        // apabila user ingin publish
        if ($data['publish_status']==true){
            $date = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
            $data['date_publish'] = $date->format('Y-m-d');
        }

        // save konten dengan nama berdasarkan title
        $contentFileName = $this->saveContent($data['content'],$data['title']);
        $data['file_content'] = $contentFileName;

        // apabila user upload thumbnail
        if ($thumbnail->getSize() != 0){
            $thumbnailFileName = $this->saveThumbnail($thumbnail,$data['title']);

            $data['file_thumbnail'] = $thumbnailFileName;
        }


        try {
            $result = $this->articleModel->insert($data);

            $this->logger->info("berhasil insert article ID: {$result}");

            return $this->responseCreated(["title"=>$data['title']]);

        } catch (\ReflectionException $e) {
            $this->logger->error("gagal membuat artikel {$data['title']} ",['error'=>$e->getMessage()]);

            return $this->responseFail("gagal membuat artikel");
        }

    }


    public function show($slug=null)
    {
        if ($slug==null){
            return $this->responseFail("artikel tidak ditemukan");
        }

        $data = $this->articleModel->where(['slug'=>$slug])->find();

        foreach ($data as $key => $value) {
            $data[$key]['file_content']   = base_url('article/content-file/' . $value['file_content']);
            $data[$key]['file_thumbnail'] = base_url('article/thumbnail/' . $value['file_thumbnail']);
        }

        return $this->responseSuccess($data);
    }

    public function update($id=null)
    {
        if ($id==null){
            return $this->responseFail("artikel tidak ditemukan");
        }

        // cari artikel
        $article = $this->articleModel->find($id);

        // simpan nama file thumbnail dan file content
        // untuk nantinya dihapus
        $thumbnailFileNamePrevious = $article['file_thumbnail'];
        $contentFileNamePrevious   = $article['file_content'];

        // dapatkan data post
        $data = $this->request->getPost();
        $thumbnail = $this->request->getFile('thumbnail');

        // validasi
        if ( $this->articleModel->validate($data) == false) {
            return $this->responseFailValidationErrors($this->articleModel->errors());
        }

        // set data essensial ke article
        $date = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));

        $article['title']            = $data['title'];
        $data['slug']                = str_replace(" ","-",$data['slug']);
        $article['slug']             = strtolower($data['slug']);
        $article['date_updated']     = $date->format('Y-m-d');
        $article['publish_status']   = filter_var($data['publish_status'],FILTER_VALIDATE_BOOLEAN);


        // save konten dengan nama berdasarkan title
        $contentFileName = $this->saveContent($data['content'],$data['title']);
        $article['file_content'] = $contentFileName;


        // apabila user upload thumbnail
        if ($thumbnail->getSize() != 0){
            $thumbnailFileName = $this->saveThumbnail($thumbnail,$data['title']);

            $article['file_thumbnail'] = $thumbnailFileName;
        }

        try {
            $result = $this->articleModel->update($article['article_id'],$data);

            $this->logger->info("berhasil update article id: {$result}");

            FileHelper::delete(FileHelper::$ARTICLE_THUMBNAIL.$thumbnailFileNamePrevious);
            FileHelper::delete(FileHelper::$ARTICLE_CONTENT_FILE.$contentFileNamePrevious);

            return $this->responseUpdated($article);

        } catch (\ReflectionException $e) {
            $this->logger->error("gagal update artikel {$data['title']} ",['error'=>$e->getMessage()]);

            return $this->responseFail("gagal update artikel");
        }
    }


    public function delete($id=null)
    {
        if ($id==null){
            return $this->responseFail("artikel tidak ditemukan");
        }

        try {
            $this->articleModel->delete($id);

            $this->logger->info("berhasil delete article id: {$id}");

            return $this->responseDeleted();

        }catch (DatabaseException $exception){
            $this->logger->error("gagal delete artikel {$id} ",['error'=>$exception->getMessage()]);

            return $this->responseFail("gagal delete artikel");
        }

    }

    /**
     * @param UploadedFile $file
     * @param string $title
     * @return string
     * <br>
     * Note :
     * - ekstensi dan replace space dari title akan dihandle disini
     */
    private function saveThumbnail(UploadedFile $file, string $title): string
    {
        $title  = str_replace(" ","-",$title);
        $title  = $title.".".$file->getClientExtension();

        $status = FileHelper::save($file,FileHelper::$ARTICLE_THUMBNAIL,$title);

        if (empty($status) == true){
            $this->logger->warning("failed save thumbnail {$title}");

        }
            return $title;
    }

    /**
     * @param string $content
     * @param string $title
     * @return string
     * <br>
     * Note :
     *  - ekstensi dan replace space dari title akan dihandle disini
     */
    public function saveContent(string $content, string $title): string
    {
        $title  = str_replace(" ","-",$title);
        $title = $title.".html";

        $status = FileHelper::write(FileHelper::$ARTICLE_CONTENT_FILE.$title,$content,false);

        if ($status==false){
            $this->logger->warning("failed save content {$title}");
        }

        return $title;
    }
}