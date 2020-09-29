<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetaSenhaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'senhaPura',
                RepeatedType::class,
                [
                    'label' => 'Redefina sua senha:',
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
                    'first_options'  =>
                        [
                            'label' => 'Nova Senha'
                        ],
                    'second_options' =>
                        [
                            'label' => 'Confirmar Nova Senha'
                        ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
