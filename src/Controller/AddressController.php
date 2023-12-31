<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    #[Route('/user/address/new', name: 'app_address')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $address->setProfile($this->getUser()->getProfile());
            $manager->persist($address);
            $manager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('address/index.html.twig', [
            "address"=>$address,
            "form"=>$form
        ]);
    }
}
