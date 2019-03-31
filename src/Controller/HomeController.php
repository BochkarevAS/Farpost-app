<?php

declare(strict_types=1);

namespace Controller;

use App\Core\Controller;
use App\Service\FileUploader;

class HomeController extends Controller
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $uid = $this->image->checkAuth();
        $images = $this->image->getImage($uid);

        return $this->render('site/image', [
            'images' => $images
        ]);
    }
}