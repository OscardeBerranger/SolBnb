<?php

namespace App\Controller;


use App\Entity\Address;
use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    #[Route('/user/new_post', name: 'app_post')]
    public function newPost(): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();
        $address = $profile->getAddress();
        return $this->render('post/create.html.twig', [
            "user"=>$user,
            "profile"=>$profile,
            "addresses"=>$address
        ]);
    }

    #[Route('/user/new_post_with_address/{id}', name: 'app_post_with_address')]
    public function newPostWithAddress(Request $request, Address $address, EntityManagerInterface $manager){
        $property = new Property();
        $profile = $this->getUser()->getProfile();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($property);
            $manager->flush($property);
            return $this->render('post/equipments.html.twig', [
                "property"=>$property,
            ]);
        }
        return $this->renderForm('post/create_with_address.html.twig',[
            "form"=>$form,
            "address"=>$address
        ]);
    }


}
