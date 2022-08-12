<?php

namespace App;

class Config
{
    private $configs = [
        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pwd'  => '',
            'database' => 'encomage'
        ]
    ];

    public function __get(string $name)
    {
        return $this->configs[$name] ?? null;
    }
}