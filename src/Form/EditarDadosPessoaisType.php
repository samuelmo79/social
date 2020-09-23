<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EditarDadosPessoaisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dadosPessoais', DadosPessoaisType::class, [
                'required' => true,
            ])
            ->add('localizacao', LocalizacaoType::class)
            ->add('imageFile', VichImageType::class, [
                'label' => 'Foto do perfil',
                'required' => false,
                'allow_delete' => false,
                'download_label' => '',
                'image_uri' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Default'],
        ]);
    }
}