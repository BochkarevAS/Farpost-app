<?php

namespace App\Core;

/**
 * В принцепе норм Мой вариант
 */
class View
{
    private $path = ROOT . '/public/views/';

    public function render($templateName, $data = [], $layoutName = 'layout/main')
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