<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    #[Route('/hello/{name}', name: 'hello', methods: ['GET'])]
    public function index(string $name): Response
    {
        return $this->render('hello/index.html.twig', [
            'name' => $name,
        ]);
    }
}
