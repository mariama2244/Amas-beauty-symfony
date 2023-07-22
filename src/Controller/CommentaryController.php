<?php

namespace App\Controller;

use DateTime;
use App\Entity\Product;
use App\Entity\Commentary;
use App\Form\CommentaryFormType;
use App\Repository\CommentaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaryController extends AbstractController
{
    #[Route('/add-commentary/{id}', name: 'app_commentary', methods: ['GET', 'POST'])]
    public function index(Product $product, Request $request, CommentaryRepository $repository): Response
    {
        $commentary = new Commentary();

        $form = $this->createForm(CommentaryFormType::class, $commentary)
        ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $commentary->setCreatedAt(new DateTime());
            $commentary->setUpdatedAt(new DateTime());

            $repository->save($commentary, true);

            $this->addflash('success', "Votre commentaire a été publié dans le produit <strong>" . $product->getTitle() . "</strong> avec succès.");
            return $this->redirectToRoute('show_home', [

                'id' => $product->getId(),
            ]);
          
        }


     

        return $this->render('render/form_commentary.html.twig', [
            'form' => $form->createView(),
        ]);
    } // end of addCommentary

    #[Route('/supprimer-commentaire/{id}', name: 'soft_delete_commentary', methods: ['GET'] )]
    public function softDeleteCommentary(Commentary $commentary,Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentary->setDeletedAt(new DateTime());

        $entityManager->getRepository(Commentary::class)->save($commentary, true);

        /** @var Product $product */
        $product= $entityManager->getRepository(Product::class)->find($request->query->get('product_id'));

        $this->addFlash('succes', "Votre commentaire a été supprimé !");

        return $this->redirectToRoute('show_article', [
          
            'id' => $product->getId(),
        ]);
    }
}
