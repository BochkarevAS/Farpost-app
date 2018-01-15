<?php

namespace App\Controller;

use App\Core\View;
use App\Service\ImageService;

class ImageController {

    private $view;
    private $imageService;

    public function __construct(View $view, ImageService $imageService) {
        $this->view = $view;
        $this->imageService = $imageService;
    }

    public function actionIndex() {
        $uid = $this->imageService->checkAuth();
        $images = $this->imageService->getImage($uid);

        return $this->view->render('site/image', [
            'images' => $images
        ]);
    }

    public function actionAddAjaxImage() {
        $uid = $this->imageService->checkAuth();
        $img = $this->imageService->insertImage($uid);

        echo json_encode($img);
        die();
    }

    public function actionShow($path, $id) {
        $this->imageService->checkAuth();
        $img = $this->imageService->showImage($id);

        return $this->view->render('site/show', [
            'img' => $img
        ]);
    }
}