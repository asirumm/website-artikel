<?php

namespace App\Helpers;

use CodeIgniter\HTTP\Files\UploadedFile;
use Exception;

class FileHelper
{
    public static string $ARTICLE_THUMBNAIL = FCPATH . 'article/thumbnail/';
    public static string $ARTICLE_CONTENT_FILE = FCPATH . 'article/content-file/';
    public static string $ARTICLE_CONTENT_IMAGE = FCPATH . 'article/content-image/';

    /*
    * @param \CodeIgniter\HTTP\Files\UploadedFile $file
    * @param string $targetDir  Folder tujuan
    * @param string $fileName   Nama file yang akan disimpan beserta ekstensi
    * @return string|null Path file yang disimpan atau null jika gagal
    */
    public static function save(UploadedFile $file, string $targetDir, string $fileName): ?string
    {
        $targetDir = rtrim($targetDir, '/') . '/';

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $targetPath = $targetDir . $fileName;

        if ($file instanceof \CodeIgniter\HTTP\Files\UploadedFile) {
            if ($file->isValid() && ! $file->hasMoved()) {
                $file->move($targetDir, $fileName, true);
                return $targetPath;
            }
        } elseif (is_file($file)) {
            if (copy($file, $targetPath)) {
                return $targetPath;
            }
        }

        return null;
    }

    public static function delete(string $filePath): bool
    {
        if (is_file($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    /**
     * Rename file.
     *
     * @param string $oldPath path file lama beserta nama file
     * @param string $newName nama file baru dengan ekstensi (tanpa folder)
     * @return string|null path baru atau null jika gagal
     */
    public static function rename(string $oldPath, string $newName): ?string
    {
        if (! is_file($oldPath)) {
            return null;
        }

        $dir     = dirname($oldPath) . '/';
        $newPath = $dir . $newName;

        return rename($oldPath, $newPath) ? $newPath : null;
    }

    /**
     * Menulis konten ke file dengan opsi append atau overwrite.
     *
     * @param string $path    Lokasi file lengkap (termasuk nama file).
     * @param string $content Isi yang akan ditulis ke file.
     * @param bool   $append  Jika true → konten ditambahkan, false → file ditimpa.
     *
     * @return bool True jika berhasil, false jika gagal.
     */
    public static function write(string $path, string $content, bool $append = false): bool
    {
        // Pastikan direktori tujuan ada
        $dir = dirname($path);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
                // Gagal membuat folder
                return false;
            }
        }

        // Tentukan mode penulisan (append atau overwrite)
        $flags = $append ? FILE_APPEND | LOCK_EX : LOCK_EX;

        // Tulis file, kembalikan true jika sukses
        return file_put_contents($path, $content, $flags) !== false;
    }

}