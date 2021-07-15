<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    private string $path = ROOT . '/templates/';

    public function render($templateName, $data = [], $layoutName = 'layout')
    {
        $data['content'] = $this->_render($templateName, $data);

        return $this->_render($layoutName, $data);
    }

    protected function _render($templateName, $data = [])
    {
        try {
            ob_start();
            $this->protectedScope($this->path . $templateName . '.php', $data);
            $output = ob_get_clean();
        } catch(\Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return $output;
    }

    protected function protectedScope($___templatePath, array $data)
    {
        extract($data);

        include $___templatePath;
    }
}