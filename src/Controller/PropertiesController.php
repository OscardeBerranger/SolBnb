<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertiesController extends AbstractController
{
    #[Route('/properties', name: 'app_properties')]
    public function index(): Response
    {
        return $this->render('properties/index.html.twig', [
            "properties"=>$this->getUser()->getProfile()->getProperties(),
        ]);
    }

    #[Route('/user/new_property', name: 'app_property')]
    public function newProperty(): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();
        $address = $profile->getAddress();
        return $this->render('properties/create.html.twig', [
            "user"=>$user,
            "profile"=>$profile,
            "addresses"=>$address
        ]);
    }

    #[Route('/user/new_property_with_address/{id}', name: 'app_property_with_address')]
    public function newPropertyWithAddress(Request $request, Address $address, EntityManagerInterface $manager){
        $property = new Property();
        $profile = $this->getUser()->getProfile();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $property->setProfile($this->getUser()->getProfile());
            $property->setStatus('app_equipements');
            $manager->persist($property);
            $image = $property->getImage();
            $image->setProperty($property);
            $manager->persist($image);
            $manager->flush($property);
            return $this->redirectToRoute('app_home', [
                "id"=>$property->getId(),
            ]);
        }
        return $this->render('properties/create_with_address.html.twig',[
            "form"=>$form,
            "address"=>$address
        ]);
    }


}
