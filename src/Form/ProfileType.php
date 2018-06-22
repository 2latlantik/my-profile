<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\FileGroup;
use App\Entity\File;
use App\Entity\Profile;

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
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPReSetData')
            )
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                array($this, 'onPostSubmit')
            )
        ;
    }

    public function onPreSetData(FormEvent $event)
    {

        /** @var Profile $data */
        $data = $event->getData();
        if (empty($data->getProfilePicture())) {
            $fileGroup = new FileGroup();
            $data->setProfilePicture($fileGroup);
        }

        if ($data->getProfilePicture()->getFiles()->isEmpty()) {
            $file = new File();
            $data->getProfilePicture()->addFile($file);
        }
    }

    public function onPostSubmit(FormEvent $event)
    {

        /** @var Profile $data */
        $data = $event->getData();
        foreach ($data->getProfilePicture()->getFiles() as $file) {
            if (empty($file->getFile()) && empty($file->getId())) {
                $data->getProfilePicture()->removeFile($file);
            }
        }

        if (0 === count($data->getProfilePicture()->getFiles())) {
            $data->setProfilePicture(null);
        }
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
