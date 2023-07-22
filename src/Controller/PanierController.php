<?php

namespace App\Controller;

use DateTime;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Command;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/voir-mon-panier', name: 'show_panier', methods: ['GET'])]
    public function showPanier(SessionInterface $session): Response
    {
        # cette instruction permet de récupérer le panier en session, et à défaut créer le panier s'il n'existe  pas
         $panier = $session->get('panier', []);
         $total =0;

        # le code qui permet de calculer le total par produit
         foreach($panier as $item) {

             $totalItem = $item['product']->getPrice() * $item['quantity'];
             $total += $totalItem;
         }
        return $this->render('panier/show_panier.html.twig', [
            'total' => $total
        ]);
    }// end function showPanier()

    //------------------------------ ADD AN ITEM------------------------
    #[Route('/ajouter-un-produit/{id}', name: 'add_item', methods: ['GET'])]
    public function addItem(Product $product, SessionInterface $session): Response
    {
        # Si dans la session le panier n'existe pas, la méthode get() retournera le second paramètre : un array vide
        $panier = $session->get('panier', []);

        if(empty($panier[$product->getId()])) {
            $panier[$product->getId()]['quantity'] = 1;
            $panier[$product->getId()]['product'] = $product;
        } else {
            // post-incrementation : quantity + 1
            // pre-incrementation : 1 + quantity
            ++$panier[$product->getId()]['quantity'];
        }

        # Ici, nous devons set() le panier en session, en lui passant $panier[]
        $session->set('panier', $panier);

        $this->addFlash('success', "The product has been added to your basket !");
        return $this->redirectToRoute('show_home');
    } // end function addItem()

    //-------------------------------- VIDER LE PANIER-----------------
    #[Route('/vider-le-panier', name: 'delete_panier', methods: ['GET'])]
    public function deletePanier(SessionInterface $session): Response
    {
        $session->remove('panier');

        $this->addFlash('success', "Your basket is empty again.");
        return $this->redirectToRoute('show_home');
    }

    //-----------------------------------DELETE ITEM--------------------------
    #[Route('/retirer-du-panier/{id}', name:'delete_item', methods: ['GET'])]
    public function deleteItem(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier');
       
        // array_key_exists() est une fonction native de PHP, qui permet de vérifier si une key existe dans un array.
        if(array_key_exists($id, $panier)) {
            unset($panier[$id]); # unset() permet de supprimer une variable (ou une clé dans un array)
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('show_panier');
    } // end delete item

    //-------------------------------------VALIDATE COMMANDE----------------------
   
    #[Route('/valider-mon-panier', name: 'validate_commande', methods: ['GET'])]
    public function validateCommande(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $panier = $session->get('panier', []);

        if(empty($panier)) {
            $this->addFlash('warning', 'Your basket is empty.');
            return $this->redirectToRoute('show_panier');
        }

        $commande = new Command();

        $commande->setCreatedAt(new DateTime());
        $commande->setUpdatedAt(new DateTime());

        $total = 0;


        foreach($panier as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;

            $commande->setQuantity($item['quantity']);
//            $product = $item['product'];
        }

//        $commande->setProduct($product);


        $commande->setStatus('in preparation');
        $commande->setUser($this->getUser());
        $commande->setTotal($total);

        $entityManager->persist($commande);
        $entityManager->flush();

        $session->remove('panier');

        $this->addFlash('success', "Congratulations, your order has been taken into account and is being prepared. You can find it in My Orders.");
        return $this->redirectToRoute('show_panier');

    }// end function validate()


} // end class
