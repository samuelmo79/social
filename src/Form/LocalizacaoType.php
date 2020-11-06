<?php

namespace App\Form;

use App\Entity\Localizacao;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Intl\Countries;

class LocalizacaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $countries = array_flip(Countries::getNames());
        $primeiroElemento = ['Selecione' => ''];

        $builder
            ->add('bairro', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo é obrigatório']),
                ],
            ])
            ->add('cidade', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo é obrigatório']),
                ],
            ])
            ->add('estado', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo é obrigatório']),
                ],
            ])
            ->add('cep', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Este campo é obrigatório']),
                ],
            ])
            ->add('pais', ChoiceType::class, [
                'choices' => array_merge($primeiroElemento, $countries),
                'constraints' => [
                    new NotBlank(['message' => 'Este campo é obrigatório']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Localizacao::class,
        ]);
    }
}
