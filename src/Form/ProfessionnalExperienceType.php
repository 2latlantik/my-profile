<?php

namespace App\Form;

use App\Entity\ProfessionalExperience;
use App\Form\Type\RichTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionnalExperienceType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'label.professionnal_experience.title',
                'ico' => 'suitcase',
            ])
            ->add('society', TextType::class, [
                'label' => 'label.professionnal_experience.society',
                'ico' => 'building',
            ])
            ->add('location', TextType::class, [
                'label' => 'label.professionnal_experience.location',
                'ico' => 'map-marker',
            ])
            ->add('description', RichTextType::class, [
                'data_class' => ProfessionalExperience::class
            ])
            ->add('start', DateType::class, [
                'label' => 'label.professionnal_experience.start',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => [
                    'class' =>  'js-datepicker'
                ],
                'ico' => 'calendar'
            ])
            ->add('end', DateType::class, [
                'label' => 'label.professionnal_experience.end',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => [
                    'class' =>  'js-datepicker'
                ],
                'ico' => 'calendar',
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProfessionalExperience::class,
        ));
    }
}
