<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionsRepository")
 */
class Questions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bonneReponse1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bonneReponse2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bonneReponse3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mauvaiseReponse1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mauvaiseReponse2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mauvaiseReponse3;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getLink(): ?Activity
    {
        return $this->link;
    }

    public function setLink(?Activity $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBonneReponse1()
    {
        return $this->bonneReponse1;
    }

    /**
     * @param mixed $bonneReponse1
     */
    public function setBonneReponse1($bonneReponse1): void
    {
        $this->bonneReponse1 = $bonneReponse1;
    }
    /**
     * @return mixed
     */
    public function getBonneReponse2()
    {
        return $this->bonneReponse2;
    }

    /**
     * @param mixed $bonneReponse2
     */
    public function setBonneReponse2($bonneReponse2): void
    {
        $this->bonneReponse2 = $bonneReponse2;
    }
    /**
     * @return mixed
     */
    public function getBonneReponse3()
    {
        return $this->bonneReponse3;
    }

    /**
     * @param mixed $bonneReponse3
     */
    public function setBonneReponse3($bonneReponse3): void
    {
        $this->bonneReponse3 = $bonneReponse3;
    }

    /**
     * @return mixed
     */
    public function getMauvaiseReponse1()
    {
        return $this->mauvaiseReponse1;
    }

    /**
     * @param mixed $mauvaiseReponse2
     */
    public function setMauvaiseReponse1($mauvaiseReponse1): void
    {
        $this->mauvaiseReponse1 = $mauvaiseReponse1;
    }
    /**
     * @return mixed
     */
    public function getMauvaiseReponse2()
    {
        return $this->mauvaiseReponse2;
    }

    /**
     * @param mixed $mauvaiseReponse2
     */
    public function setMauvaiseReponse2($mauvaiseReponse2): void
    {
        $this->mauvaiseReponse2 = $mauvaiseReponse2;
    }
    /**
     * @return mixed
     */
    public function getMauvaiseReponse3()
    {
        return $this->mauvaiseReponse3;
    }

    /**
     * @param mixed $mauvaiseReponse3
     */
    public function setMauvaiseReponse3($mauvaiseReponse3): void
    {
        $this->mauvaiseReponse3 = $mauvaiseReponse3;
    }

}
