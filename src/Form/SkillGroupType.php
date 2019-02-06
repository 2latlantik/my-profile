<?php

namespace App\Form;

use App\Entity\SkillGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('label', null, [
                'label' => 'label.skill_group.label',
                'attr' => [
                    'placeholder' => 'label.skill_group.label'
                ]
            ])
            ->add('skills', CollectionType::class, [
                'entry_type' => SkillType::class,
                'label' => 'label.skills',
                'allow_add' => true,
                'allow_delete' => true,
                'prototype_name' => '__skillcollection__',
                'by_reference' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SkillGroup::class,
        ));
    }
}
