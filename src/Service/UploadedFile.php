<?php

namespace App\Service;

use App\Exceptions\FileException;

class UploadedFile
{
    const IMAGE_DIR = ROOT . '/public/images/';

    /**
     * @throws FileException
     */
    public function upload(): string
    {
        $info = pathinfo($_FILES['file']['name']);
        $ext  = $info['extension'] ?? "." . $info['extension'];

        $file = self::IMAGE_DIR.md5(uniqid()).'.'.$ext;

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            throw new FileException('Не удалось переместить файл');
        }

        return basename($file);
    }

    public function delete(?string $filename): void
    {
        if ($filename) {
            unlink(self::IMAGE_DIR.$filename);
        }
    }
}