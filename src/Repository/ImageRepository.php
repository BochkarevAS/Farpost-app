<?php

namespace App\Repository;

use App\Core\Db;

class ImageRepository
{
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getImage($uid)
    {
        /**
         * Выучить PDO
         * Хорошо что queryBuelder не делал =)
         */
        $sql    = "SELECT id, img, uid, date FROM image WHERE uid = :uid";
        $result = $this->db->query($sql, ['uid' => $uid]);

        return $result->fetchAll();
    }

    public function showImage($id)
    {
        /**
         * Обязательно выучить PDO !!!
         */
        $sql    = "SELECT img FROM image WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $img = $result->fetch();

        return $img['img'];
    }

    /**
     * Это пиздец нет слов
     */
    public function setImage($uid, $makeSeed)
    {
        $file = $_FILES['file'];

        /**
         *  Блять у меня истерика ...
         */
        $uploaddir = dirname($_SERVER['SCRIPT_FILENAME']) . "/UploadedFiles/";

        /**
         * Ебать конечно
         */
        $year = date("Y");
        $month = date("m");
        $day = date("d");

        /**
         * Я такой подход не видел много лет
         */
        if (!file_exists("$uploaddir$year/")) {
            mkdir("$uploaddir$year/", 0777);
        }

        if (!file_exists("$uploaddir/$year/$month/")) {
            mkdir("$uploaddir$year/$month/", 0777);
        }

        if (!file_exists("$uploaddir$year/$month/$day/")) {
            mkdir("$uploaddir$year/$month/$day/", 0777);
        }

        $info = pathinfo($file['name']);
        $ext = empty($info['extension']) ? "" : "." . $info['extension'];
        $uploadfile = "$year/$month/$day/" . $makeSeed . $ext;

        if (move_uploaded_file($file['tmp_name'], $uploaddir . $uploadfile)) {

            /**
             * Это репозиторй или uploader ???
             * Нарушение SOLID
             */
            $sql = "INSERT INTO image (img, uid) VALUES (:img, :uid) RETURNING id, img";
            $result = $this->db->query($sql, [
                'img' => $uploadfile,
                'uid' => $uid
            ]);

            $img = $result->fetch();
        }

        return $img;
    }
}