<?php

class Image {

    public static function getImage() {

        $db = Db::getConnection();

        $sql = "SELECT img, added_by, date FROM image;";
        $result = $db->prepare($sql);
        $result->execute();

        return $result->fetchAll();
    }



    public static function insertImage() {

        echo 111;

        die;

        $db = Db::getConnection();

        $file = $_FILES['file'];

        $uploaddir = ROOT . "/Resource/UploadedFiles/";

        $year = date("Y");
        $month = date("m");
        $day = date("d");

        if (!file_exists("$uploaddir$year/")) {
            mkdir("$uploaddir$year/", 0700);
        }
        if (!file_exists("$uploaddir/$year/$month/")) {
            mkdir("$uploaddir$year/$month/", 0700);
        }
        if (!file_exists("$uploaddir$year/$month/$day/")) {
            mkdir("$uploaddir$year/$month/$day/", 0700);
        }

        $info = pathinfo($file['name']);                                    // Анализируем путь. Всё вернётся в виде ассойиативного массива
        $ext = empty($info['extension']) ? "" : "." . $info['extension'];   // Смотрим есть ли расшерение
        $uploadfile = "$year/$month/$day/" . 111 . $ext;

        if (move_uploaded_file($file['tmp_name'], $uploaddir . $uploadfile)) {

            $sql = "INSERT INTO image (img, added_by) VALUES ('$uploadfile', 1)";
            $result = $db->prepare($sql);

            $result->bindParam('img', $img, PDO::PARAM_STR);
            $result->bindParam('added_by', $added_by, PDO::PARAM_STR);
            $result->execute();
        }
    }

}


