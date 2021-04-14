<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\GroupListTransformer;

class FigureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name')
            ->add('text', null, [
                'attr' => [
                    'rows' => 10,
                ]
            ])
            ->add('group', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'name',
                'allow_extra_fields' => true,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'attr' => [
                    'placeholder' => 'Url de la video ex : https://www.youtube.com/embed/rz9Nx6ZDhNo',
                ],
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false, //https://symfony.com/doc/current/form/form_collections.html
                'allow_delete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }

}
