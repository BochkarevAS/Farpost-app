<?php

class ImageController {

    public function actionIndex() {

        User::checkAuth();



//        if ($_POST['submit']) {
//            Image::insertImage();
//        }

        require_once(ROOT . '/Resources/views/site/image.php');

    }

}