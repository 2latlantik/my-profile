<?php

namespace App\Form;

use App\Entity\FileGroup;
use App\Form\Type\UploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FileGroupType
 * @package App\Form
 */
class FileGroupType extends AbstractType
{

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars = array_merge(
            $view->vars,
            [
                'multiple'  => $options['multiple']
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'files',
                CollectionType::class,
                [
                    'entry_type'    => UploadType::class
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => FileGroup::class,
                'multiple' => false
            ]
        );
    }
}
