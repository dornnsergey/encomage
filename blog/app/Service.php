<?php

declare(strict_types=1);

namespace App;

class Service
{
    public const REQUIRED = '<strong>Error!</strong> Please, fill in all fields.';

    public static function getPositivePostsCount(array $posts): int
    {
        return count(array_filter($posts, fn($post) => $post->rating >= 4));
    }

    public static function getNegativePostsCount(array $posts): int
    {
        return count(array_filter($posts, fn($post) => $post->rating && $post->rating < 3));
    }

    public static function validateStore(): array
    {
        $trimmed = self::Trim($_POST);

        $data['validated']['name'] = $trimmed['name'] ?? null;
        $data['validated']['text'] = $trimmed['text'] ?? null;

        if (empty($data['validated']['name'])) {
            $data['errors']['message'] = self::REQUIRED;
        }

        if (empty($data['validated']['text'])) {
            $data['errors']['message'] = self::REQUIRED;
        }

        return $data;
    }

    public static function Trim(array $data): array
    {
        foreach ($data as &$item) {
            $item = trim($item);
        }

        return $data;
    }
}