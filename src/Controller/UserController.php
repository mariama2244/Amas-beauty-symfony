<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\RegisterFormType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/inscription', name: 'register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserRepository $repository, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        # this code allow you to know if user is connected

        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user)
            ->handleRequest($request);
   
            // Condition to see your ur bdd
       if($form->isSubmitted() && $form->isValid()) {
   
           # set les propriétés qui ne sont pas dans le formulaire et oubligatoires en BDD
           $user->setCreatedAt(new DateTime());
           $user->setUpdatedAt(new DateTime());
   
           # Set les roles du user. Cette propriétés est un array[].
           $user->setRoles(['ROLE_USER']);
   
           # on dois resseter manuellement la valeur du password, car par défault il n'est pas hashé
           #pour cele, nous devons utiliser une méthode de hashage appelée hashPassword() :
           # => cette méthode attend 2 arguements : user, $plainpassword
           $user->setPassword(
               $passwordHasher->hashPassword($user, $user->getPassword())
           );
   
           $repository->save($user, true);
   
           $this->addFlash('success', "Your registration has been successfully completed !!!");
   
           return $this->redirectToRoute('app_login');
   
   
       }
         
   
        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }// end register


    // ---------------------- SHOW WIG --------------------------------
    #[Route('/wig', name: 'show_wig', methods: ['GET'])]
    public function ShowWig(ProductRepository $repository): Response
    {
        $products = $repository->findBy(['collection' => 'wig']);

        return $this->render('product/show_wig.html.twig', [
            'products' => $products,
        ]);
    }

      // ---------------------- SHOW EYELASH --------------------------------
      #[Route('/eyelash', name: 'show_eyelash', methods: ['GET'])]
      public function ShowEyelash(ProductRepository $repository): Response
      {
          $products = $repository->findBy(['collection' => 'eyelashe']);
  
          return $this->render('product/show_eyelash.html.twig', [
              'products' => $products,
          ]);
      }

      // ---------------------- SHOW BONNETS --------------------------------
      #[Route('/bonnet', name: 'show_bonnet', methods: ['GET'])]
      public function ShowBonnet(ProductRepository $repository): Response
      {
          $products = $repository->findBy(['collection' => 'bonnet']);
  
          return $this->render('product/show_bonnet.html.twig', [
              'products' => $products,
          ]);
      }


        // ---------------------- SHOW HAIR BUNDLE --------------------------------
        #[Route('/hair-bundle', name: 'show_hairbundle', methods: ['GET'])]
        public function ShowHairbundle(ProductRepository $repository): Response
        {
            $products = $repository->findBy(['collection' => 'hairbundle']);
    
            return $this->render('product/show_hairbundle.html.twig', [
                'products' => $products,
            ]);
        }

            // ---------------------- SHOW HAIR CLIPS --------------------------------
            #[Route('/hair-clips', name: 'show_hairclips', methods: ['GET'])]
            public function ShowHairclips(ProductRepository $repository): Response
            {
                $products = $repository->findBy(['collection' => 'hairclips']);
        
                return $this->render('product/show_hairclips.html.twig', [
                    'products' => $products,
                ]);
            }

                  // ---------------------- SHOW LIP GLOSS --------------------------------
                  #[Route('/lipgloss', name: 'show_lipgloss', methods: ['GET'])]
                  public function ShowLipgloss(ProductRepository $repository): Response
                  {
                      $products = $repository->findBy(['collection' => 'lipgloss']);
              
                      return $this->render('product/show_lipgloss.html.twig', [
                          'products' => $products,
                      ]);
                  }
    


} // end class
