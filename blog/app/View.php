<?php

namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    /**
     * @throws ViewNotFoundException
     */
    public static function render(string $view, array $params = []): string
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (! file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        extract($params);

        ob_start();

        include_once $viewPath;

        return ob_get_clean();
    }
}