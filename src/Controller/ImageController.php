<?php

namespace App\Controller;

use App\Core\Container;
use App\Core\Controller;
use App\Service\Image;

class ImageController extends Controller
{
    private $imageService;

    public function __construct(Container $container, Image $imageService)
    {
        $this->imageService = $imageService;

        parent::__construct($container);
    }

    public function actionIndex()
    {
        $uid = $this->imageService->checkAuth();
        $images = $this->imageService->getImage($uid);

        return $this->render('site/image', [
            'images' => $images
        ]);
    }

    public function actionAddAjaxImage()
    {
        $uid = $this->imageService->checkAuth();
        $img = $this->imageService->insertImage($uid);

        echo json_encode($img);
        die();
    }

    public function actionShow($path, $id)
    {
        $this->imageService->checkAuth();
        $img = $this->imageService->showImage($id);

        return $this->render('site/show', [
            'img' => $img
        ]);
    }
}