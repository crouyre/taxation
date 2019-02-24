<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(options={"comment":"Table contenant les seuils d'imposition"});
 * @ORM\Entity(repositoryClass="App\Repository\EdgeRepository")
 */
class Edge
{
    //For the test
    const EXERCISE_YEAR = 2014;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(
     *  type="integer")
     */
    private $id;

    /**
     * @ORM\Column(
     *  type="float",
     *  options={"comment":"Taux"})
     */
    private $rate;

    /**
     * @ORM\Column(
     *  type="integer",
     *  options={"comment":"Palier de début en RP du seuil"})
     */
    private $start;

    /**
     * @ORM\Column(
     *  type="integer",
     *  nullable=true, 
     *  options={"comment":"Palier de fin en RP du seuil"})
     */
    private $end;

    /**
     * @ORM\Column(
     *  type="integer",
     *  options={"comment":"Année d'exécution du seuil"})
     */
    private $year;

    public function getId(): int
    {
        return $this->id;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function setStart(int $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?int
    {
        return $this->end;
    }

    public function setEnd(int $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }
}
