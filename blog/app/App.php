<?php

namespace App;

class App
{
    public static DB $db;

    public function __construct(
        private Router $router,
        private string $requestUri,
        private string $requestMethod,
        private Config $config
    )
    {
        static::$db = new DB($this->config->db);
    }

    public function run()
    {
        try {
            $this->router->resolve($this->requestUri, $this->requestMethod);
        } catch (\Exception $e) {
            http_response_code(404);
            exit($e->getMessage());
        }
    }
}