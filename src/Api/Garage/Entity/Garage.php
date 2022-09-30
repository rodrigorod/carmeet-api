<?php

namespace App\Api\Garage\Entity;

use App\Api\Car\Entity\Car;
use App\Api\User\Entity\User;
use App\Api\User\Entity\UserInterface;
use App\DependencyInjection\TimerAwareTrait;
use App\Repository\GarageRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GarageRepository::class)
 *
 * Class Garage.
 */
class Garage implements GarageInterface
{
    use TimerAwareTrait;

    /**
     * Garage id.
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     *
     * @Assert\Unique()
     * @Assert\Type("integer")
     *
     * @Groups(groups={"create", "garage"})
     */
    protected Uuid $id;

    /**
     * Garage car list.
     *
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="garage")
     *
     * @Groups(groups={"create", "garage"})
     */
    protected ?Collection $cars;

    /**
     * Garage user.
     *
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="garage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups(groups={"create"})
     */
    protected UserInterface $user;

    public function __construct() {
        $this->cars = new ArrayCollection();
        $this->createdAt = new DateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCars(): ?Collection
    {
        return $this->cars;
    }

    /**
     * {@inheritDoc}
     */
    public function setCars(?Collection $cars): self
    {
        $this->cars = $cars;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setGarage($this);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getGarage() === $this) {
                $car->setGarage(null);
            }
        }

        return $this;
    }
}
