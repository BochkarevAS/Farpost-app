<?php

class ImageController {

    public function actionIndex() {
        $uid = User::checkAuth();
        $images = Image::getImage($uid);

        require_once(ROOT . '/Resources/views/site/image.php');
    }

    public function actionAddAjaxImage() {
        $uid = User::checkAuth();
        Image::insertImage($uid);
    }

    public function actionShow($id) {
        User::checkAuth();
        $img = Image::showImage($id);

        require_once(ROOT . '/Resources/views/site/show.php');
    }
}