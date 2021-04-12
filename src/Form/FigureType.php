<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\Group;
use App\Entity\Video;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Form\DataTransformer\GroupListTransformer;

class FigureType extends AbstractType
{
    public $groupRepository;

    public function __construct(GroupRepository $groupRepository){
        $this->groupRepository = $groupRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('text')
            ->add('group', EntityType::class, [
                //'mapped' => false,
                'class' => Group::class,
                'choice_label' => 'name',
                // 'choices' => $this->SetSelectList(),
            ])
            ->add('new_group', TextType::class, [
                'mapped' => false,
                'label' => 'nom du groupe',
                'required' => false,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'attr' => [
                    'placeholder' => 'Url de la video ex : https://www.youtube.com/embed/rz9Nx6ZDhNo',
                ],
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false, //https://symfony.com/doc/current/form/form_collections.html
            ]);

            $builder->get('new_group')->addEventListener(
                FormEvents::PRE_SUBMIT,
                function(FormEvent $event) {
                    // Desactiver la liste de sélection
                    $select = $event->getForm()->getParent()->get('group');
                    if ($select->getViewData() === 'add') {
                        $event->getForm()->getParent()->remove('group');
                    }
                }
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $newChoice = new ChoiceView(array(), 'add', 'Ajouter un groupe'); // <- new option
        $view->children['group']->vars['choices'][] = $newChoice;//<- adding the new option
    }

}
