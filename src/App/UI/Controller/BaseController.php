<?php

namespace App\UI\Controller;

class BaseController
{
    protected function render(string $view, array $data = []): string
    {
        $viewPath = $this->getViewPath($view);
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("view $view not found: {$viewPath}");
        }

        extract($data);

        ob_start();

        include $viewPath;

        return ob_get_clean();
    }

    private function getViewPath(string $view): string
    {
        return __DIR__ . "/../View/{$view}.php";
    }
}
