<?php

namespace App\Service;

use App\Core\Db;

class FileUploader
{
    const UPLOAD_FILE = ROOT . '/public/images/';

    protected $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function upload($user)
    {
        $info = pathinfo($_FILES['file']['name']);
//        $ext  = empty($info['extension']) ? "" : "." . $info['extension'];
        $ext  = $info['extension'] ?? "." . $info['extension'];

        $file = self::UPLOAD_FILE . md5(uniqid()) . $ext;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            /**
             * Убрать отсюда эту херню и зделать нормально !!!!!!!!!!!!!!!!!
             */
            $sql = "INSERT INTO image (img, uid) VALUES (:img, :uid) RETURNING id, img";

            $result = $this->db->query($sql, [
                'file' => $file,
                'user' => $user
            ]);

            $img = $result->fetch();
        }

        return $img;
    }
}