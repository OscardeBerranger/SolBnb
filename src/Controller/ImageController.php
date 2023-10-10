<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Property;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/image/{id}', name: 'app_image')]
    public function index(Property $property): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class);
        return $this->render('image/index.html.twig', [
            'property'=>$property,
            'form'=>$form
        ]);
    }
    #[Route('/image/create/{id}', name: 'app_image_create')]
    public function addImage(Request $request, Property $property, EntityManagerInterface $manager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $image->setProperty($property);
            $manager->persist($image);
            $manager->flush();
        }

        return $this->redirectToRoute('app_image', ['id'=>$property->getId()]);
    }
}
