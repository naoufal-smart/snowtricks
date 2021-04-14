<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Image as ImageConstraint;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var Image|null $image */
        $image = $options['data'] ?? null;
        $isEdit = $image && $image->getId();

        $imageConstraints = [
            new ImageConstraint([

            ])
        ];

        if(!$isEdit || !$image->getFilename()){
            $imageConstraints[] = new NotNull([
                'message' => "Veuillez uploader une image"
                ]
            );
        }

        $builder
            ->add('name')
            ->add('filename', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'constraints' => $imageConstraints,
               'required' => false,
            ])
/*            ->add('figure', EntityType::class, [
                'class' => Figure::class,
                'choice_label' => 'name',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
