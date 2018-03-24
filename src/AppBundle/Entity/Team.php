<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 */
class Team
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Gamer", mappedBy="team")
     */
    private $gamers;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getGamers()
    {
        return $this->gamers;
    }

    /**
     * @param mixed $gamers
     */
    public function setGamers($gamers)
    {
        $this->gamers = $gamers;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gamers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add gamer
     *
     * @param \AppBundle\Entity\Gamer $gamer
     *
     * @return Team
     */
    public function addGamer(\AppBundle\Entity\Gamer $gamer)
    {
        $this->gamers[] = $gamer;

        return $this;
    }

    /**
     * Remove gamer
     *
     * @param \AppBundle\Entity\Gamer $gamer
     */
    public function removeGamer(\AppBundle\Entity\Gamer $gamer)
    {
        $this->gamers->removeElement($gamer);
    }
}
