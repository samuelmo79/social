<?php

namespace App\Form;

use App\Entity\AlbumFoto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AlbumFotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, [
                'label' => 'Título',
                'constraints' => [
                    new NotBlank(['message' => 'Este campo é obrigatório']),
                ],
            ])
            ->add('descricao', TextareaType::class, [
                'label' => 'Descrição'
            ])
            ->add('fotos', CollectionType::class, [
                'entry_type' => FotoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AlbumFoto::class,
        ]);
    }
}
