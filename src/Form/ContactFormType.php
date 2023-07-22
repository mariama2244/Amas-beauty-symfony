<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       
        ->add('email', EmailType::class, [
            'label' => 'Email'
        ])
        ->add('sujet', TextType::class, [
            'label' => 'sujet'
        ])
        ->add('product', ChoiceType::class, [
            'label' => 'Product',
            'choices' => [
                "Wig" => "wig",
                "Eyelash" => "eyelash",
                "Bonnet" => "bonnet",
                "Hairclip" => "hairclip",
                "Bundle" => "bundle",
                "Lipgloss" => "lipgloss",
                "Sujet general" => "Sujet general"
            ]
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Message'
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Valider',
            'validate' => false,
            'attr' => [
                'class' => 'd-block mx-auto col-3 btn btn-warning'
            ]
        ])

        ->add('captcha', Recaptcha3Type::class, [
            'constraints' => new Recaptcha3(),
            'action_name' => 'contact',
        ]); 

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
