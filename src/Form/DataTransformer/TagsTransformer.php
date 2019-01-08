<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Service\TagManager;
use Symfony\Component\Form\DataTransformerInterface;

class TagsTransformer implements DataTransformerInterface
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
     * @param mixed $value
     * @return array
     */
    public function transform($value): array
    {
        return [
            'data'  => implode(',', $value)
        ];
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function reverseTransform($value): array
    {
        $names = array_unique(array_filter(array_map('trim', explode(',', $value['data']))));

        $tags = $this->tagManager->findWithConditions(['name' => $names]);

        $newNames = array_diff($names, $tags);

        foreach ($newNames as $name) {
            $tag = new Tag();
            $tag->setName($name);
            $tags[] = $tag;
        }

        return $tags;
    }
}
