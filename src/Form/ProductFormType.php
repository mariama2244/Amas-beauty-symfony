<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du produits'
            ])
            ->add('descript', TextareaType::class, [
                'label' => 'Description du produits'
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'data_class' => null,
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix du produit',
            ])
            ->add('stock', TextType::class, [
                'label' => 'Quantité en stock'
            ])
            ->add('collection', ChoiceType::class, [
                'label' => 'Collection',
                'choices' => [
                    'Wig' => 'wig',
                    'Eyelashe' => 'eyelashe',
                    'Bonnet' => 'bonnet',
                    'Hairbundle' => 'hairbundle',
                    'Hairclips' => 'hairclips',
                    'Lipgloss' => 'lipgloss'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Ajouter",
                'validate' => false,
                'attr' => [
                    'class' => "d-block mx-auto my-3 btn btn-success col-3"
                ],
            ])
           
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'allow_file_upload' => true,
            'photo' => null
            // configure your form options here
        ]);
    }
}
