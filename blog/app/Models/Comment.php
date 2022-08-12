<?php

declare(strict_types=1);

namespace App\Models;

use App\App;

class Comment
{
    public static function create(array $data): bool
    {
        $query = 'INSERT INTO `comments` (`name`, `text`, `post_id`) values (:name, :text, :post_id)';

        $stmt = App::$db->prepare($query);

        return $stmt->execute($data);
    }
}