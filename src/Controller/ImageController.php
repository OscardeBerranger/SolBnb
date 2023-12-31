<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(): Response
    {
        return $this->render('image/index.html.twig', [
            'controller_name' => 'ImageController',
        ]);
    }
    #[Route('/image/create/{id}', name: 'app_image_create')]
    public function addImage(Property $property): Response
    {

        return $this->render('image/index.html.twig', [
            'controller_name' => 'ImageController',
        ]);
    }
}
