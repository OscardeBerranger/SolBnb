<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation')]
    public function index(Property $property, Request $request, EntityManagerInterface $manager, ReservationRepository $reservationRepository): Response
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
    public function showReservations(ReservationRepository $reservationRepository ){
        $profile = $this->getUser()->getProfile();
        $string = 'test';


        $calendars = $reservationRepository->findByProfile($this->getUser()->getProfile());
        $json = "";
        foreach($calendars as $calendar){
            $data = [
                'id'=>$calendar->getId(),
                'start'=>$calendar->getBookStart()->format('Y-m-d H:i'),
                'end'=>$calendar->getBookEnd()->format('Y-m-d H:i'),
                'title'=>"user ".$calendar->getProfile()->getName()." have booked this day"
            ];
            $datas[]=$data;

            if (empty($datas)){
                $datas=[""];
            }

            $json = json_encode($datas);
        }
        return $this->render('reservation/show.html.twig', [
            'json' => $json
        ]);



//        $posts = $postRepository->findAll();
//        $postsRender = array();
//        if ($request->get('query')){
//            $query = $request->get('query');
//            foreach ($posts as $post){
//                if (str_contains($post->getContent(), $query)){
//                    array_push($postsRender, $post);
//                }
//            }
//            return $this->render('post/index.html.twig', [
//                'posts'=>$postsRender
//            ]);
//        }
//        return $this->render('post/index.html.twig', [
//            'posts'=>$posts
//        ]);
    }

    #[Route('/deleteReservation/{id}', name: 'app_reservation_deleteReservation')]
    public function deleteReservation(Reservation $reservation, EntityManagerInterface $manager){
        $manager->remove($reservation);
        $manager->flush();
        return $this->redirectToRoute('app_home');
    }

}
