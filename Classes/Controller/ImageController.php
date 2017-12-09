<?php

class ImageController {

    public function actionIndex() {

        $uid = User::checkAuth();
        $images = Image::getImage($uid);

//        var_dump($images);
//        die;

        require_once(ROOT . '/Resources/views/site/image.php');
    }

    public function actionImg() {

        $uid = User::checkAuth();
        Image::insertImage($uid);

    }

}