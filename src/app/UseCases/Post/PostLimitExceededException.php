<?php

namespace App\UseCases\Post;

use Exception;

class PostLimitExceededException extends Exception
{
    public function __construct(
      string $message = "",
      protected int $error_code = 1
    )
    {
        parent::__construct($message, $error_code);
    }
}
