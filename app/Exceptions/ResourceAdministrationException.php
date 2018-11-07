<?php

namespace App\Exceptions;

use Exception;

class ResourceAdministrationException extends Exception
{
  public function render()
  {
    return ['errors' => 'You are not authorized.'];
  }
}

