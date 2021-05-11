<?php

namespace App\Form;


use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image as ImageConstraint;

class FigureImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $imageConstraints = [
            new ImageConstraint([

            ])
        ];

        $builder
            ->add('name')
            ->add('filename', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'constraints' => $imageConstraints,
               'required' => false,
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
