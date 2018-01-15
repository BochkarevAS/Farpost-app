<?php

namespace App\Repository;

use App\Core\Db;

class ImageRepository {

    private $db;

    public function __construct(Db $db) {
        $this->db = $db;
    }

    public function getImage($uid) {
        $db = $this->db->getConnection();

        $sql = "SELECT id, img, uid, date FROM image WHERE uid = :uid";
        $result = $db->prepare($sql);

        $result->bindParam('uid', $uid, \PDO::PARAM_STR);
        $result->execute();

        return $result->fetchAll();
    }

    public function showImage($id) {
        $db = $this->db->getConnection();

        $sql = "SELECT img FROM image WHERE id = :id";
        $result = $db->prepare($sql);

        $result->bindParam('id', $id, \PDO::PARAM_STR);
        $result->execute();
        $img = $result->fetch();

        return $img['img'];
    }

    public function setImage($uid, $makeSeed) {
        $db = $this->db->getConnection();

        $file = $_FILES['file'];
        $uploaddir = dirname($_SERVER['SCRIPT_FILENAME']) . "/UploadedFiles/";

        $year = date("Y");
        $month = date("m");
        $day = date("d");

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
            $sql = "INSERT INTO image (img, uid) VALUES (:img, :uid) RETURNING id, img";
            $result = $db->prepare($sql);

            $result->bindParam('img', $uploadfile, \PDO::PARAM_STR);
            $result->bindParam('uid', $uid, \PDO::PARAM_STR);
            $result->execute();

            $img = $result->fetch();
        }

        return $img;
    }
}