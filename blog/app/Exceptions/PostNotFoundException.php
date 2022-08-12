<?php

namespace App\Exceptions;

class PostNotFoundException extends \Exception
{
    protected $message = 'Post Not Found.';
}