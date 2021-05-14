<?php

namespace App\Tests\Form\DataTransformer;

use App\Entity\Tag;
use App\Form\DataTransformer\TagsTransformer;
use App\Service\TagManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class TagsTransformerTest extends TestCase
{

    public function testCreateTagsArrayFromString()
    {
        $transformer = $this->getMockedTransformer();
        $tags = $transformer->reverseTransform(array('data' => 'Hello, Demo'));

        $this->assertCount(2, $tags);
        $this->assertEquals('Demo', $tags[1]->getName());
    }

    public function testUseAlreadyTag()
    {
        $tag = new Tag();
        $tag->setName('Chat');
        $transformer = $this->getMockedTransformer([$tag]);
        $tags = $transformer->reverseTransform(array('data' => 'Chat, Chien'));

        $this->assertCount(2, $tags);
        $this->assertSame($tag, $tags[0]);
    }

    public function testRemoveEmptyTag()
    {
        $tags = $this
            ->getMockedTransformer()
            ->reverseTransform(array('data' => 'Demo,, Demo, , Demo, '));

        $this->assertCount(1, $tags);
    }

    public function testRemoveDuplicateTags()
    {
        $tags = $this
            ->getMockedTransformer()
            ->reverseTransform(array('data' => 'Hello,, Demo, , , '));
        $this->assertCount(2, $tags);
        $this->assertEquals('Demo', $tags[1]->getName());
    }

    private function getMockedTransformer($result = [])
    {

        $tagRepository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tagRepository->expects($this->any())
            ->method('findBy')
            ->willReturn($result);

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();


        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($tagRepository));


        $tagManager = new TagManager($entityManager);

        return new TagsTransformer($tagManager);
    }

}