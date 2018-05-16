<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProfileType
 * @package App\Form
 */
class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder
            ->add('surname', TextType::class, [
                'label' => 'label.surname'
            ])
            ->add('name', TextType::class, [
                'label' => 'label.name'
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'label.birth_date',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'attr' => [
                    'class' =>  'js-datepicker'
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'label.gender',
                'choices' => [
                    'label.gender.m' => 'm',
                    'label.gender.f' => 'f'
                ],
                'required' => false
            ])
            ->add('profilePicture', FileGroupType::class, [
                'label' => 'label.profile_picture',
                'multiple' => false,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Profile::class,
        ));
    }
}
