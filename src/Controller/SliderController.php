<?php

namespace App\Controller;

use DateTime;
use App\Entity\Slider;
use App\Form\SliderFormType;
use App\Repository\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class SliderController extends AbstractController
{
    // --------------------------------- CREATE-SLIDER ---------------------------------
    #[Route('/dash-slider', name: 'create_slider', methods: ['GET', 'POST'])]
    public function createSlider(SliderRepository $repository, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $slider = new Slider();

        $form_slider = $this->createForm(SliderFormType::class, $slider)
        ->handleRequest($request);

        if($form_slider->isSubmitted() && $form_slider->isValid()) {

            $slider->setCreatedAt(new DateTime());
            $slider->setUpdatedAt(new DateTime());

            $photo = $form_slider->get('photo')->getData();

            if($photo) {
                $this->handleFile($photo, $slider, $slugger);
            } 

            $repository->save($slider, true);

            $this->addFlash('success', "The slider has been added successfully !");
            return $this->redirectToRoute('create_slider');
        } // end if($form_slider)

        $sliders = $entityManager->getRepository(Slider::class)->findBy(['deletedAt' => null]);
        
        return $this->render('slider/slider.html.twig', [
            'form_slider' => $form_slider->createView(),
            'sliders' => $sliders
        ]);
    } // end ajouterSlider()
    // ----------------------------------------------------------------------------------



    // --------------------------------- UPDATE-SLIDER ---------------------------------
    #[Route('/modifier-un-slider/{id}', name: 'update_slider', methods: ['GET', 'POST'])]
    public function updateSlider( Slider $slider, Request $request, SliderRepository $repository, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response 
    {
        # Récupération de la photo actuelle
        $currentPhoto = $slider->getPhoto();

        $form_slider = $this->createForm(SliderFormType::class, $slider, [
            'photo' => $currentPhoto
        ])
            ->handleRequest($request);
    
        if($form_slider->isSubmitted() && $form_slider->isValid()) {

            $slider->setUpdatedAt(new DateTime());
                    

            $photo = $form_slider->get('photo')->getData();

            if($photo) {
                $this->handleFile($photo, $slider, $slugger);

            }else{
            
                $slider->setPhoto($currentPhoto);
            // end if($newPhoto)
            }
            $repository->save($slider, true);

            $this->addFlash('success', "The slider has been modified successfully !");
            return $this->redirectToRoute('create_slider');
        } //end if($form_slider)

        $sliders = $entityManager->getRepository(Slider::class)->findBy(['deletedAt' => null]);

        return $this->render('slider/slider.html.twig', [
            'form_slider' => $form_slider->createView(),
            'slider' => $slider,
            'sliders' => $sliders,
        ]);
    } // end updateSlider()
    // ----------------------------------------------------------------------------------



    // ------------------------------ HARD-DELETE-SLIDER -------------------------------
    #[Route('/supprimer-slider/{id}', name: 'hard_delete_slider', methods: ['GET'])]
    public function hardDeleteSlider(Slider $slider, SliderRepository $repository): Response
    {
        $repository->remove($slider, true);

        $this->addFlash('success', "The slider has been permanently deleted !");
        return $this->redirectToRoute('create_slider');
    } // end hardDeleteSlider()
    // ----------------------------------------------------------------------------------



    // ----------------------------------- HANDLEFILE -----------------------------------
    private function handleFile(UploadedFile $photo, Slider $slider, SluggerInterface $slugger)
    {
        $extension = '.' . $photo->guessExtension();
        $safeFilename = $slugger->slug(pathinfo($photo->getClientOriginalExtension(), PATHINFO_FILENAME));

        $newFilename = $safeFilename . '-' . uniqid() . $extension;

        try{
            $photo->move($this->getParameter('uploads_dir'), $newFilename);
            $slider->setPhoto($newFilename);
        } catch (FileException $exception) {
            // code à exécuter en cas d'erreur
        }
    } // end handleFile()
    // ----------------------------------------------------------------------------------
} // end classController()

