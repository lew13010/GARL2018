<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rank
 *
 * @ORM\Table(name="rank")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RankRepository")
 */
class Rank
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
     * @ORM\Column(name="points", type="string", length=255)
     */
    private $points;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tier")
     */
    private $tier;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Division")
     */
    private $division;

    /**
     * @var integer
     *
     * @ORM\Column(name="matchs", type="integer")
     */
    private $matchs;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Gamer", inversedBy="rank")
     */
    private $gamer;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set points
     *
     * @param string $points
     *
     * @return Rank
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return string
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set matchs
     *
     * @param integer $matchs
     *
     * @return Rank
     */
    public function setMatchs($matchs)
    {
        $this->matchs = $matchs;

        return $this;
    }

    /**
     * Get matchs
     *
     * @return integer
     */
    public function getMatchs()
    {
        return $this->matchs;
    }

    /**
     * Set tier
     *
     * @param \AppBundle\Entity\Tier $tier
     *
     * @return Rank
     */
    public function setTier(\AppBundle\Entity\Tier $tier = null)
    {
        $this->tier = $tier;

        return $this;
    }

    /**
     * Get tier
     *
     * @return \AppBundle\Entity\Tier
     */
    public function getTier()
    {
        return $this->tier;
    }

    /**
     * Set division
     *
     * @param \AppBundle\Entity\Division $division
     *
     * @return Rank
     */
    public function setDivision(\AppBundle\Entity\Division $division = null)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return \AppBundle\Entity\Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set gamer
     *
     * @param \AppBundle\Entity\Gamer $gamer
     *
     * @return Rank
     */
    public function setGamer(\AppBundle\Entity\Gamer $gamer = null)
    {
        $this->gamer = $gamer;

        return $this;
    }

    /**
     * Get gamer
     *
     * @return \AppBundle\Entity\Gamer
     */
    public function getGamer()
    {
        return $this->gamer;
    }

    public function __toString()
    {
        return $this->getPoints();
    }
}
