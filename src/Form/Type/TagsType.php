<?php

namespace App\Form\Type;

use App\Form\DataTransformer\TagsTransformer;
use App\Service\TagManager;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsType extends AbstractType
{

    /**
     * @var TagManager
     */
    private $tagManager;

    /**
     * TagsTransformer constructor.
     * @param TagManager $tagManager
     */
    public function __construct(TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('data', HiddenType::class, [
            'attr' => [
                'class' => 'tags--values'
            ]
        ]);
        $builder->add('front', TextType::class, [
            'attr' => [
                'class' => 'tags--input'
            ]
        ]);
        $builder->addModelTransformer(new CollectionToArrayTransformer(), true);
        $builder->addModelTransformer(new TagsTransformer($this->tagManager), true);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('required', false);
    }
}
