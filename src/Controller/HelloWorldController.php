<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloWorldController
{

    #[Route('/hello/{name}', name: 'hello', methods: ['GET'])]
    public function index(string $name): Response
    {
        return new Response(
            '<html><body><div>Hello ' . $name .'!</div></body></html>'
        );
    }

}