<?php

namespace App\Exceptions;

use Exception;

class EditUserException extends Exception
{
  public function render()
  {
    return ['errors' => 'Not enough authorization to admin user.'];
  }
}

