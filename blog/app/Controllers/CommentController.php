<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Comment;
use App\Service;

class CommentController
{
    public function store()
    {
        $data = Service::validateStore();

        if (! empty($data['errors'])) {
            echo json_encode($data['errors']);
            return;
        }

        Comment::create($data['validated'] + ['post_id' => (int)$_GET['post']]);

        $response['success'] = true;
        $response['message'] = '<strong>Success!</strong> Comment has been added.';

        echo json_encode($response);
    }
}