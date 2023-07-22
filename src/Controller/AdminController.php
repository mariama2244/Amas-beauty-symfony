<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin/tableau-de-bord', name: 'show_dashboard', methods: ['GET'])]
    public function ShowDashboard(ProductRepository $repository): Response
    {
        $products = $repository->findBy(['deletedAt' => null ]); // pour éviter de show les produits deleted

        return $this->render('admin/show_dashboard.html.twig', [
            'products' => $products,
        ]);
    }

    //--------------------------------Show archiver-----------------------------------------
    #[Route('admin/voir-les-archives', name: 'show_archiver', methods: ['GET'])]
    public function showArchives(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAllArchived();
              

        return $this->render('admin/product/show_archiver.html.twig', [
            'products' => $products,
           
        ]);
    } // end showArchives()
}
