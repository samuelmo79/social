<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('conteudo', TextareaType::class, [
                'attr' => [
                    'placeholder' => "O que vamos postar hoje?",
                    'rows' => '5'
                ]
            ])
            ->add('privacidade', ChoiceType::class, [
                'choices' => [
                    'Amigos' => 'Amigos',
                    'Público' => 'Publico',
                    'Privado' => 'Privado'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Imagem',
                'required' => false,
                'allow_delete' => false,
                'download_label' => '',
                'image_uri' => true,
                'attr' => [
                    'lang' => "pt_BR"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
