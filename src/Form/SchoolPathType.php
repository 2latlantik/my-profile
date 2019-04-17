<?php

namespace App\Form;

use App\Entity\SchoolPath;
use App\Form\Type\RichTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SchoolPathType
 * @package App\Form
 */
class SchoolPathType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'label.school_path.title',
                'ico' => 'graduation-cap',
            ])
            ->add('school', TextType::class, [
                'label' => 'label.school_path.school',
                'ico' => 'university',
            ])
            ->add('degree', TextType::class, [
                'label' => 'label.school_path.degree_level',
                'ico' => 'line-chart',
            ])
            ->add('description', RichTextType::class, [
                'data_class' => SchoolPath::class,
                'label' => 'label.description'
            ])
            ->add('start', DateType::class, [
                'label' => 'label.school_path.start',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => [
                    'class' =>  'js-datepicker'
                ],
                'ico' => 'calendar'
            ])
            ->add('end', DateType::class, [
                'label' => 'label.school_path.end',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => [
                    'class' =>  'js-datepicker'
                ],
                'ico' => 'calendar'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => SchoolPath::class,
        ));
    }
}
