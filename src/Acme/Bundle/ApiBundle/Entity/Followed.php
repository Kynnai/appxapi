<?php

namespace Acme\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Followed
 *
 * @ORM\Table(name="followed")
 * @ORM\Entity(repositoryClass="Acme\Bundle\ApiBundle\Repository\FollowedRepository")
 */
class Followed
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

