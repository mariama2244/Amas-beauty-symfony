<?php

namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $product = new Product();
        $manager->persist($product);

        // for the contact
        // for ($i = 0; $i < 5; $i++ ) {
        //     $contact = new Contact();
        //     $contact ->setName($this->faker->name())
        //             ->setEmail($this->faker->email())
        //             ->setSujet('Demande n°' + ($i . 1))
        //             ->setProduct($this->faker->priduct())
        //             ->setMessage($this->faker->text());
            

        //     $manager->persist($contact);       
        // }

        $manager->flush();
    }
}
