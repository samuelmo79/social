<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail *'
            ])
            ->add('dadosPessoais', DadosPessoaisType::class, [
                'required' => true,
            ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $user = $event->getData();
            if (!$user || null === $user->getId()) {
                $form->add(
                    'senhaPura',
                    RepeatedType::class,
                    [
                        'label' => 'Defina sua senha',
                        'type' => PasswordType::class,
                        'invalid_message' => 'Os campos da senha devem corresponder.',
                        'options' =>
                            [
                                'attr' =>
                                    [
                                        'class' => 'password-field'
                                    ]
                            ],
                        'required' => true,
                        'constraints' => [
                            new NotBlank(['message' => 'Este campo é obrigatório']),
                        ],
                        'first_options' =>
                            [
                                'label' => 'Senha *'
                            ],
                        'second_options' =>
                            [
                                'label' => 'Confirmar Senha *'
                            ],
                    ]
                );
            } else {
                $form->add(
                    'senhaPura',
                    HiddenType::class,
                    [
                        'label' => false,
                        'mapped' => false
                    ]
                );
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
