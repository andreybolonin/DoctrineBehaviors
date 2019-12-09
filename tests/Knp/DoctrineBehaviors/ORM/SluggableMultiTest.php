<?php

declare(strict_types=1);

namespace Tests\Knp\DoctrineBehaviors\ORM;

use Doctrine\Common\EventManager;
use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;

require_once 'EntityManagerProvider.php';

class SluggableMultiTest extends \PHPUnit_Framework_TestCase
{
    use EntityManagerProvider;

    protected function getUsedEntityFixtures()
    {
        return [
            'BehaviorFixtures\\ORM\\SluggableMultiEntity'
        ];
    }

    protected function getEventManager()
    {
        $em = new EventManager();

        $em->addEventSubscriber(
            new \Knp\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriber(
                new ClassAnalyzer(),
                false,
                'Knp\DoctrineBehaviors\Model\Sluggable\Sluggable'
            )
        );

        return $em;
    }

    public function testSlugLoading()
    {
        $em = $this->getEntityManager();

        $entity = new \BehaviorFixtures\ORM\SluggableMultiEntity();

        $expected = 'the+name+title';

        $entity->setName('The name');

        $em->persist($entity);
        $em->flush();

        $this->assertNotNull($id = $entity->getId());

        $em->clear();

        $entity = $em->getRepository('BehaviorFixtures\ORM\SluggableMultiEntity')->find($id);

        $this->assertNotNull($entity);
        $this->assertEquals($entity->getSlug(), $expected);
    }

    public function testNotUpdatedSlug()
    {
        $em = $this->getEntityManager();

        $entity = new \BehaviorFixtures\ORM\SluggableMultiEntity();

        $expected = 'the+name+title';

        $entity->setName('The name');

        $em->persist($entity);
        $em->flush();

        $entity->setDate(new \DateTime());

        $em->persist($entity);
        $em->flush();

        $this->assertEquals($entity->getSlug(), $expected);
    }

    public function testUpdatedSlug()
    {
        $em = $this->getEntityManager();

        $entity = new \BehaviorFixtures\ORM\SluggableMultiEntity();

        $expected = 'the+name+title';

        $entity->setName('The name');

        $em->persist($entity);
        $em->flush();

        $this->assertEquals($entity->getSlug(), $expected);

        $expected = 'the+name+2+title';

        $entity->setName('The name 2');

        $em->persist($entity);
        $em->flush();

        $this->assertEquals($entity->getSlug(), $expected);
    }
}
