<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Booking
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="datetime")
   */
  private $beginAt;

  /**
   * @ORM\Column(type="datetime")
   */
  private $endAt;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $name;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\Computer", inversedBy="bookings")
   */
  private $computer;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
   */
  private $user;

  public function getId()
  {
    return $this->id;
  }

  public function getBeginAt()
  {
    return $this->beginAt;
  }

  public function setBeginAt(\DateTime $beginAt)
  {
    $this->beginAt = $beginAt;
  }

  public function getEndAt()
  {
    return $this->endAt;
  }

  public function setEndAt(\DateTime $endAt)
  {
    $this->endAt = $endAt;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName(string $name)
  {
    $this->name = $name;
  }

  public function getComputer(): ?Computer
  {
    return $this->computer;
  }

  public function setComputer(?Computer $computer): self
  {
    $this->computer = $computer;

    return $this;
  }


  public function getUser(): ?User
  {
    return $this->user;
  }

  public function setUser(?User $user): self
  {
    $this->user = $user;

    return $this;
  }
}