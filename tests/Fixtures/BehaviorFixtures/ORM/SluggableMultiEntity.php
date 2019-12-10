<?php

declare(strict_types=1);

namespace BehaviorFixtures\ORM;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;

/**
 * @ORM\Entity
 */
class SluggableMultiEntity
{
    use Sluggable;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->date = (new DateTime())->modify('-1 year');
    }

    /**
     * Returns object id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getSluggableFields()
    {
        return ['name', 'title'];
    }

    public function getTitle()
    {
        return 'title';
    }

    /**
     * @param $values
     * @return mixed|string
     */
    public function generateSlugValue($values)
    {
        $sluggableText = implode(' ', $values);

        return strtolower(str_replace(' ', '+', $sluggableText));
    }
}
