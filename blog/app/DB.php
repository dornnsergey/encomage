<?php

namespace App;

use PDO;

/**
 * @mixin PDO $pdo
 */
class DB
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['pwd'],
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}