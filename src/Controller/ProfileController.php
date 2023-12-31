<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/user/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();
        return $this->render('profile/index.html.twig', [
            'user'=>$user,
            'profile'=>$profile
        ]);
    }
}
