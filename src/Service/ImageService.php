<?php

namespace App\Service;

use App\Repository\ImageRepository;

class ImageService {

    private $imageRepository;

    public function __construct(ImageRepository $imageRepository) {
        $this->imageRepository = $imageRepository;
    }

    public function getImage($uid) {
        return $this->imageRepository->getImage($uid);
    }

    public function showImage($id) {
        return $this->imageRepository->showImage($id);
    }

    public function checkAuth() {

        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header('Location: /user/registration');
        die();
    }

    public function insertImage($uid) {
        return $this->imageRepository->setImage($uid, $this->makeSeed());
    }

    private function makeSeed() {
        list($usec, $sec) = explode(' ', microtime());
        return $sec . (int)($usec * 100000);
    }
}


