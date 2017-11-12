<?php
declare(strict_types=1);
namespace Enginewerk\Promas\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function indexAction(Request $request)
    {
        return new Response('Promas@' . $request->getHost());
    }
}
