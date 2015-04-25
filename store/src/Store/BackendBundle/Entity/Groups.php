<?php
/**
 * Created by PhpStorm.
 * User: wac30
 * Date: 21/04/15
 * Time: 15:00
 */

namespace Store\BackendBundle\Entity;


use Symfony\Component\Security\Core\Role\RoleInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Groups
 * @package Store\BackendBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Groups implements RoleInterface{

    /**
     * @var
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var
     *
     * @ORM\Column(name="name", type="string", length=300)
     */
    private $name;


    /**
     * @var
     *
     * @ORM\Column(name="role", type="string", length=20, unique=true)
     */
    private $role;

    /**
     * @var
     *
     * @ORM\ManyToMany(targetEntity="Jeweler", mappedBy="groups")
     */
    private $jeweler;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jeweler = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Groups
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
     * Set role
     *
     * @param string $role
     * @return Groups
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     * @return Groups
     */
    public function addJeweler(\Store\BackendBundle\Entity\Jeweler $jeweler)
    {
        $this->jeweler[] = $jeweler;

        return $this;
    }

    /**
     * Remove jeweler
     *
     * @param \Store\BackendBundle\Entity\Jeweler $jeweler
     */
    public function removeJeweler(\Store\BackendBundle\Entity\Jeweler $jeweler)
    {
        $this->jeweler->removeElement($jeweler);
    }

    /**
     * Get jeweler
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJeweler()
    {
        return $this->jeweler;
    }
}
