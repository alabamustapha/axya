<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ResourceAdministrationException extends Exception
{
  public function render()
  {
    // return ['errors' => 'You are not authorized.'];

    return response()->json(['errors' => 'You are not authorized.'],  Response::HTTP_UNAUTHORIZED);//401
  }
}

