<?php

declare(strict_types=1);

namespace App\Models;

use App\App;
use App\Exceptions\PostNotFoundException;


class Post
{
    public array $comments = [];

    public function __construct()
    {
        $this->comments = $this->getAssociatedComments();
    }

    public static function all(): array|false
    {
        $query = 'SELECT * FROM `posts` ORDER BY `id` DESC';

        return App::$db->query($query)->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function findOrFail(int $id)
    {
        $query = 'SELECT * FROM `posts` WHERE `id` = ?';

        $stmt = App::$db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, static::class);
        $stmt->execute([$id]);

        $post = $stmt->fetch();

        if (! $post) {
            throw new PostNotFoundException();
        }

        return $post;
    }

    public static function create(array $data): bool
    {
        $query = 'INSERT INTO `posts` (`name`, `text`) values (:name, :text)';

        $stmt = App::$db->prepare($query);

        return $stmt->execute($data);
    }

    public function rate(int $rating): bool
    {
        $query = 'UPDATE posts SET `rating` = ? WHERE `id` = ?';

        $stmt = App::$db->prepare($query);

        return $stmt->execute([$rating, $this->id]);
    }

    private function getAssociatedComments(): array|false
    {
        $query = 'SELECT * FROM `comments` WHERE `post_id` = ' . $this->id . ' ORDER BY `id` DESC';

        $stmt = App::$db->query($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Comment::class);

        return $stmt->fetchAll();
    }
}