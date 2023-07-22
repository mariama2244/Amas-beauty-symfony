<?php

namespace App\Form;

use App\Entity\Commentary;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaryFormType extends AbstractType
{
    private Security $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('comment', TextareaType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => "Votre commentaire...",
                'class' => 'editor' # Cette class nous permet d'activer CKEditor
            ],
            'constraints' => [
                new NotBlank(),
            ],
         ])
     
       ;

       
        # Si l'utilisateur est connecté, alors on affichera le bouton submit du commentaire
        if($this->security->getUser()) {
            $builder
                ->add('submit', SubmitType::class, [
                    'label' => 'Commenter <i class="bi bi-send"></i>',
                    'label_html' => true,
                    'validate' => false,
                    'attr' => [
                        'class' => "d-block btn btn-sm btn-outline-light my-3 col-3 mx-auto"
                    ]
                ])
            ;
        }
    }

    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentary::class,
        ]);
    }
}
