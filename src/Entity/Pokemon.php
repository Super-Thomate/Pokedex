<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PokemonRepository")
 */
class Pokemon
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type2;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PokeSprite", mappedBy="pokeId")
     */
    private $pokeSprites;

    /**
     * @ORM\Column(type="integer")
     */
    private $generation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $form;

    public function __construct()
    {
        $this->pokeSprites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    /**
     * @return Collection|PokeSprite[]
     */
    public function getPokeSprites(): Collection
    {
        return $this->pokeSprites;
    }

    public function addPokeSprite(PokeSprite $pokeSprite): self
    {
        if (!$this->pokeSprites->contains($pokeSprite)) {
            $this->pokeSprites[] = $pokeSprite;
            $pokeSprite->setPokeId($this);
        }

        return $this;
    }

    public function removePokeSprite(PokeSprite $pokeSprite): self
    {
        if ($this->pokeSprites->contains($pokeSprite)) {
            $this->pokeSprites->removeElement($pokeSprite);
            // set the owning side to null (unless already changed)
            if ($pokeSprite->getPokeId() === $this) {
                $pokeSprite->setPokeId(null);
            }
        }

        return $this;
    }

    public function getGeneration(): ?int
    {
        return $this->generation;
    }

    public function setGeneration(int $generation): self
    {
        $this->generation = $generation;

        return $this;
    }

    public function getForm(): ?string
    {
        return $this->form;
    }

    public function setForm(?string $form): self
    {
        $this->form = $form;

        return $this;
    }
}
