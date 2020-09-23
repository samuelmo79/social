<?php

namespace App\Form;

use App\Entity\Evento;
use App\Enum\PrivacidadeEnum;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título *'
            ])
            ->add('descricao', CKEditorType::class, [
                'label' => 'Conteúdo *',
                'config' => [
                    'toolbar' => 'ferramentas',
                    'required' => true,
                ]
            ])
            ->add('dataEvento', DateType::class, [
                'label' => 'Data/Hora do Evento *',
                'widget' => 'single_text'
            ])
            ->add('tipoEvento', ChoiceType::class, [
                'label' => 'Tipo de Evento *',
                'choices' => array_flip(PrivacidadeEnum::getPrivacidade())
            ])
            ->add('rua', TextType::class, [
                'label' => 'Rua *'
            ])
            ->add('numero', TextType::class, [
                'label' => 'Número *'
            ])
            ->add('complemento', TextType::class, [
                'label' => 'Complemento'
            ])
            ->add('bairro', TextType::class, [
                'label' => 'Bairro *'
            ])
            ->add('estado', TextType::class, [
                'label' => 'Estado/Provincia *'
            ])
            ->add('cep', TextType::class, [
                'label' => 'CEP *'
            ])
            ->add('imagem')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
