<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

trait RedirectToOriginTrait
{
    public function redirectToOrigin(Request $request) {
        return $this->redirect($request->headers->get('referer'));
    }
}