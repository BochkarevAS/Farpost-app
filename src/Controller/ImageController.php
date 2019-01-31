<?php

namespace App\Controller;

use App\Core\Controller;
use App\Core\View;
use App\Service\FileUploader;

/**
 * Вот нахуя стока контроллеров ???
 */
class ImageController extends Controller
{
    private $uploader;

    /**
     * При расширении контроллера можно сделать так что бы не вызывать родительский контроллер !!!
     */
    public function __construct(View $view, FileUploader $uploader)
    {
        $this->uploader = $uploader;

        parent::__construct($view);
    }

    /**
     * DI на методы не к чему
     */
    public function index()
    {
        /**
         * Получается размазывание тонким слоем по всему проекту
         * Подход норм конечно но без фанатизма Контроллер -> Сервис -> Репозиторий
         */
        $uid = $this->image->checkAuth();
        $images = $this->image->getImage($uid);

        return $this->render('site/image', [
            'images' => $images
        ]);
    }

    public function create()
    {
        $uid = $this->image->checkAuth();
        $img = $this->image->insertImage($uid);

        echo json_encode($img);
        die();
    }

    /**
     * Использовать тайп хинты
     */
    public function show($path, $id)
    {
        $this->image->checkAuth();
        $img = $this->image->showImage($id);

        return $this->render('site/show', [
            'img' => $img
        ]);
    }
}