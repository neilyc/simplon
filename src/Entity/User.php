<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity()
 */
class User
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $firstname;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $name;

  public function __construct()
  {
    $this->bookings = new ArrayCollection();
  }

  public function getId()
  {
    return $this->id;
  }

  public function getFirstname()
  {
    return $this->firstname;
  }

  public function setFirstname(string $firstname)
  {
    $this->firstname = $firstname;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName(string $name)
  {
    $this->name = $name;
  }

}