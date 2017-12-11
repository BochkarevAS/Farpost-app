<?php

class ImageController {

    private $image;

    public function __construct() {
        $this->image = new Image();
    }

    public function actionIndex() {
        $uid = $this->image->checkAuth();
        $images = $this->image->getImage($uid);

        require_once(ROOT . '/Resources/views/site/image.php');
    }

    public function actionAddAjaxImage() {
        $uid = $this->image->checkAuth();
        $this->image->insertImage($uid);
    }

    public function actionShow($id) {
        $this->image->checkAuth();
        $img = $this->image->showImage($id);

        require_once(ROOT . '/Resources/views/site/show.php');
    }
}