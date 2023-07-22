<?php

namespace App\Form;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SliderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'data_class' => null,
                'mapped' => false,
                'attr' => [
                    'class' => $options['photo'] !== null ? $options['photo'] : ''
                ],
                'constraints' => [
                    new Image([
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'maxSize' => '5M'
                    ]) 
                ]
            ])
            ->add('ordre', TextType::class, [
                'label' => 'Ordre'
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer slider",
                'validate' => false,
                'attr' => [
                    'class' => "d-block mx-auto my-3 col-4 btn btn-lg btn-outline-success"
                ],
            ])
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Slider::class,
            'allow_file_upload' => true,
            'photo' => null
        ]);
    }
}
