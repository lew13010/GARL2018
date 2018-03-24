<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 15/11/2017
 * Time: 00:22
 */

namespace AppBundle\Service;


use AppBundle\Entity\Gamer;
use AppBundle\Entity\Rank;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Api
{
    private $em;
    private $key;
    private $season;

    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->key = $container->getParameter('api_key');
        $this->season = $container->getParameter('app')['season'];
    }

    public function getRanking($url)
    {
        if (preg_match('/id\//', $url) === 1) {
            $split = preg_split('/id\//', $url);
            $id = str_replace('/', '', $split[1]);
        }

        if (preg_match('/profiles\//', $url) === 1) {
            $split = preg_split('/profiles\//', $url);
            $id = str_replace('/', '', $split[1]);
        }

        if (isset($id)) {
            $endpoint = 'https://api.rocketleaguestats.com/v1/player?unique_id=' . $id . '&platform_id=1&apikey=' . $this->key;
            try {
                $json = json_decode(file_get_contents($endpoint), true);
                return array('json' => $json, 'steamId' => $id);
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setRanking(Gamer $joueur)
    {
        $id = $joueur->getSteamId();

        $endpoint = 'https://api.rocketleaguestats.com/v1/player?unique_id=' . $id . '&platform_id=1&apikey=' . $this->key;
        $json = json_decode(file_get_contents($endpoint), true);

        $ranks = $json['rankedSeasons'][$this->season];

        if (isset($ranks[13])) {
            $tier = $this->em->getRepository('AppBundle:Tier')->find($ranks[13]['tier'] + 1);

            if ($ranks[13]['tier'] > 0) {
                $division = $this->em->getRepository('AppBundle:Division')->find($ranks[13]['division'] + 2);
            } else {
                $division = $this->em->getRepository('AppBundle:Division')->find(1);
            }

            $rankPoints = $ranks[13]['rankPoints'];
            $rankPlayed = $ranks[13]['matchesPlayed'];
        } else {
            $rankPoints = 100;
            $rankPlayed = 0;
            $tier = $this->em->getRepository('AppBundle:Tier')->find(1);
            $division = $this->em->getRepository('AppBundle:Division')->find(1);
        }

        $r = new Rank();
        $r->setGamer($joueur);
        $r->setPoints($rankPoints);
        $r->setMatchs($rankPlayed);
        $r->setTier($tier);
        $r->setDivision($division);

        $this->em->persist($r);
        $this->em->flush();
    }

    public function setUpdate(Gamer $joueur)
    {
        $id = $joueur->getSteamId();

        $endpoint = 'https://api.rocketleaguestats.com/v1/player?unique_id=' . $id . '&platform_id=1&apikey=' . $this->key;
        $json = json_decode(file_get_contents($endpoint), true);

        $ranks = $json['rankedSeasons'][$this->season];

        if (isset($ranks[13])) {
            $tier = $this->em->getRepository('AppBundle:Tier')->find($ranks[13]['tier'] + 1);

            if ($ranks[13]['tier'] > 0) {
                $division = $this->em->getRepository('AppBundle:Division')->find($ranks[13]['division'] + 2);
            } else {
                $division = $this->em->getRepository('AppBundle:Division')->find(1);
            }

            $rankPoints = $ranks[13]['rankPoints'];
            $rankPlayed = $ranks[13]['matchesPlayed'];
        } else {
            $rankPoints = 100;
            $rankPlayed = 0;
            $tier = $this->em->getRepository('AppBundle:Tier')->find(1);
            $division = $this->em->getRepository('AppBundle:Division')->find(1);
        }


        $r = $this->em->getRepository('AppBundle:Rank')->findOneBy(array('gamer' => $joueur->getId()));

        $r->setPoints($rankPoints);
        $r->setMatchs($rankPlayed);
        $r->setTier($tier);
        $r->setDivision($division);

        $this->em->persist($r);
        $this->em->flush();
    }
}
