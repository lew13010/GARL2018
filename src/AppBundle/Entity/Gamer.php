<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gamer
 *
 * @ORM\Table(name="gamer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GamerRepository")
 */
class Gamer
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
     * @var string
     *
     * @ORM\Column(name="steam", type="string", length=255, nullable=true)
     */
    private $steam;

    /**
     * @var string
     *
     * @ORM\Column(name="steam_id", type="string", length=255, nullable=true)
     */
    private $steamId;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Team", inversedBy="gamers")
     */
    private $team;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Rank", mappedBy="gamer")
     */
    private $rank;


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
     * @return Gamer
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
     * Set steam
     *
     * @param string $steam
     *
     * @return Gamer
     */
    public function setSteam($steam)
    {
        $this->steam = $steam;

        return $this;
    }

    /**
     * Get steam
     *
     * @return string
     */
    public function getSteam()
    {
        return $this->steam;
    }

    /**
     * @return string
     */
    public function getSteamId(): string
    {
        return $this->steamId;
    }

    /**
     * @param string $steamId
     */
    public function setSteamId(string $steamId)
    {
        $this->steamId = $steamId;
    }


    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }


    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set rank
     *
     * @param \AppBundle\Entity\Rank $rank
     *
     * @return Gamer
     */
    public function setRank(\AppBundle\Entity\Rank $rank = null)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return \AppBundle\Entity\Rank
     */
    public function getRank()
    {
        return $this->rank;
    }
}
