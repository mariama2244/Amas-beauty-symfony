<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                     'message' => 'This field cannot be empty : {{ value }}'
                    ]),
                    new Length([
                        'min' => 6,
                        'max' => 180,
                        'minMessage' => 'Your email must include at least {{ limit }} caractères. (email : {{ value }}',
                        'maxMessage' => 'Your email must include at least{{ limit }} caractères.'
                    ]),
                 ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty : {{ value }}'
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 255,
                        'minMessage' => 'The value must include at least {{ limit }} caractères.',
                        'maxMessage' => 'The value must include at least {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty : {{ value }}'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'The value must include at least {{ limit }} caractères.',
                        'maxMessage' => 'The value must include at least {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty : {{ value }}'
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 100,
                        'minMessage' => 'The value must include at least {{ limit }} caractères.',
                        'maxMessage' => 'The value must include at least{{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Civility',
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                    'Non binary' => 'non-binary'
                ],
                'expanded' => true,
                'label_attr' => [
                    'class' => 'radio-inline'
                ],
                'choice_attr' => [
                    'class' => 'radio-inline'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'This field cannot be empty : {{ value }}'
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accept the conditions',
                'mapped' => false,
          
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Validate',
                'validate' => false,
                'attr' => [
                    'class' => 'd-block mx-auto col-3 btn btn-warning'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
