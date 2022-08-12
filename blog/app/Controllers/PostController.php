<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Post;
use App\Service;
use App\View;

class PostController
{
    public function index()
    {
        $posts = Post::all();

        $negativeCount = Service::getNegativePostsCount($posts);
        $positiveCount = Service::getPositivePostsCount($posts);

        echo View::render('index', compact('posts', 'positiveCount', 'negativeCount'));
    }

    public function store()
    {
        $data = Service::validateStore();

        if (! empty($data['errors'])) {
            echo json_encode($data['errors']);
            return;
        }

        Post::create($data['validated']);

        $response['success'] = true;
        $response['message'] = '<strong>Success!</strong> Post has been created.';

        echo json_encode($response);
    }


    public function rate()
    {
        if (isset($_SESSION['userAlreadyRatePost'])) {
            $_SESSION['flash'] = 'You have already do it.';
            header('location: /');
            exit();
        }

        $validated = Service::Trim($_POST);

        $post = Post::findOrFail((int)$validated['id']);

        $post->rate((int)$validated['rating']);

        $_SESSION['userAlreadyRatePost'] = true;

        header('location: /');
    }
}