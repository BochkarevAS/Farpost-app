<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->render('base');
    }
}