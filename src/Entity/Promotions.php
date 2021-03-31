<?php

namespace App\Entity;

use App\Repository\PromotionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=PromotionsRepository::class)
 */
class Promotions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Nom is required")
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Prix is required")
     * @Assert\Date
     * @var string A "Y-m-d" formatted value
     */
    private $datefin;

    /**
     * @ORM\OneToMany(targetEntity=Pro::class, mappedBy="promotion")
     */
    private $pros;

    public function __construct()
    {
        $this->pros = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDatefin(): ?string
    {
        return $this->datefin;
    }

    public function setDatefin(string $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * @return Collection|Pro[]
     */
    public function getPros(): Collection
    {
        return $this->pros;
    }

    public function addPro(Pro $pro): self
    {
        if (!$this->pros->contains($pro)) {
            $this->pros[] = $pro;
            $pro->setPromotion($this);
        }

        return $this;
    }

    public function removePro(Pro $pro): self
    {
        if ($this->pros->removeElement($pro)) {
            // set the owning side to null (unless already changed)
            if ($pro->getPromotion() === $this) {
                $pro->setPromotion(null);
            }
        }

        return $this;
    }


}
