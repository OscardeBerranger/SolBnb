<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation')]
    public function index(Property $property, Request $request, EntityManagerInterface $manager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $reservation->setProperty($property);
            $reservation->setProfile($this->getUser()->getProfile());
            $manager->persist($reservation);
            $manager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('reservation/booking.html.twig', [
            'property'=>$property,
            "form"=>$form
        ]);
    }


    #[Route('/showReservations', name: 'app_reservation_showReservations')]
    public function showReservations(){
        $reservations = $this->getUser()->getProfile()->getReservations();
        return $this->render('reservation/show.html.twig', [
            'reservations'=>$reservations
        ]);
    }

}
