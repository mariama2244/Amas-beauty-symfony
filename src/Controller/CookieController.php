<?php

namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CookieController extends AbstractController
{
    
    
    public function setCookie(Request $request) {
        $cookie = new Cookie(
                      "cookie_name_here",                      // Cookie name
                      1,                                       // Cookie content
                      (new DateTime('now'))->modify("+1 day"), // Expiration date
                      "/",                                     // Path
                      "localhost",                             // Domain
                      $request->getScheme() === 'https',       // Secure
                      false,                                   // HttpOnly
                      true,                                    // Raw
                      'Strict'                                 // SameSite policy
                  );
        $res = new JsonResponse();
        $res->headers->setCookie($cookie);
        return $res;
    }// #[Route('/cookie', name: 'set_cookie')]
  

    public function getCookie(Request $request)
    {
        $myCookieValue = $request->cookies->get('my_cookie');

        // Use the cookie value as needed

        return new Response();
    }
}


