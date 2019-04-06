<?php

namespace App\Form;

use App\Entity\Skill;
use App\Form\Type\MyRangeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('label', null, [
                'label' => 'label.skill.label'
            ])
            ->add('progression', MyRangeType::class, [
                'label' => 'label.skill.progression',
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 5
                ]
            ])
            ->add('notEvaluated', null, [
                'label' => 'label.skill.not_evaluated',
                'attr' => [
                    'class' => 'not--evaluated--input'
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Skill::class,
        ));
    }
}
