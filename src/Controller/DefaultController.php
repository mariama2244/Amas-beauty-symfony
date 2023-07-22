<?php

namespace App\Controller;

use App\Repository\SliderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'show_home', methods:['GET'])]

    public function showHome(SliderRepository $sliderRepository): Response
    {
        $slider1 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'slider1'
        ]);
        $slider2 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'slider2'
        ]);
        $slider3 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'slider3'
        ]);

        return $this->render('default/show_home.html.twig', [
            'slider1' => $slider1,
            'slider2' => $slider2,
            'slider3' => $slider3
        ]);
    } // end

    #[Route('/condition', name: 'show_condition', methods: ['GET'])]
    public function showCondition(): Response
    {
        return $this->render('footer/condition.html.twig');
    } // end condition

    #[Route('/about-us', name: 'show_aboutus', methods: ['GET'])]
    public function showAboutus(): Response
    {
        return $this->render('footer/about-us.html.twig');
    } // end about us

    #[Route('/return', name: 'show_return', methods: ['GET'])]
    public function showReturn(): Response
    {
        return $this->render('footer/return.html.twig');
    } // end return

    #[Route('/cookies', name: 'show_cookies', methods: ['GET'])]
    public function showCookies(): Response
    {
        return $this->render('cookie/cookie.html.twig');
    } // end cookie

    #[Route('/politique', name: 'show_politique', methods: ['GET'])]
    public function showPolitique(): Response
    {
        return $this->render('footer/politique.html.twig');
    } // end cookie

  
}// end class
