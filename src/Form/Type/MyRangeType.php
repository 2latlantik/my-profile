<?php

namespace App\Form\Type;

use App\Form\DataTransformer\MyRangeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class MyRangeType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('max', $options['attr'])) {
            $view->vars['max_range'] = $options['attr']['max'];
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $rangeOptions = [
            'class' => 'range--input'
        ];
        foreach ($options['attr'] as $key => $value) {
            $rangeOptions += [$key => $value];
        }
        $builder
            ->add('range', RangeType::class, [
                'label' => false,
                'attr' => $rangeOptions,

            ])
            ->add('value', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'range--value',
                    'size' => 3
                ]
            ]);
        $builder->addModelTransformer(new MyRangeTransformer(), true);
    }
}
