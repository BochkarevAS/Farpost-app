<?php

class Image {

    public static function getImage($uid) {
        $db = Db::getConnection();

        $sql = "SELECT img, added_by, date FROM image WHERE added_by = :added_by";
        $result = $db->prepare($sql);

        $result->bindParam('added_by', $uid, PDO::PARAM_STR);
        $result->execute();

        return $result->fetchAll();
    }

    public static function insertImage($uid = 1) {
        $db = Db::getConnection();

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
        $uploadfile = "$year/$month/$day/" . Image::makeSeed() . $ext;

        if (move_uploaded_file($file['tmp_name'], $uploaddir . $uploadfile)) {

            $sql = "INSERT INTO image (img, added_by) VALUES (:img, :added_by) RETURNING img";
            $result = $db->prepare($sql);

            $result->bindParam('img', $uploadfile, PDO::PARAM_STR);
            $result->bindParam('added_by', $uid, PDO::PARAM_STR);
            $result->execute();

            $img = $result->fetch();
        }

        echo json_encode($img);
        die();
    }

    public static function makeSeed() {
        list($usec, $sec) = explode(' ', microtime());
        return $sec . (int)($usec * 100000);
    }
}


