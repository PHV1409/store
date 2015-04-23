<?php

namespace Store\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Slider
 *
 * @ORM\Table(name="slider", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity(repositoryClass="Store\BackendBundle\Repository\SliderRepository")
 */
class Slider
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="text", nullable=true)
     */
    private $caption;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=300, nullable=true)
     */
    private $image;


    /**
     * @var file
     *
     * Attribut qui représentera mon fichier uploadé
     *
     * @Assert\Image(
     *      minWidth = 100,
     *      maxWidth = 3000,
     *      minHeight = 100,
     *      maxHeight = 2500,
     *      minWidthMessage = "La largeur de l'image est trop petite",
     *      maxWidthMessage = "La largeur de l'image est trop grande",
     *      minHeightMessage = "La hauteur de l'image est trop petite",
     *      maxHeightMessage = "La hauteur de l'image est trop grande",
     * )
     */
    protected $file;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;



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
     * Set caption
     *
     * @param string $caption
     * @return Slider
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Slider
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Slider
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Slider
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set product
     *
     * @param \Store\BackendBundle\Entity\Product $product
     * @return Slider
     */
    public function setProduct(\Store\BackendBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     * @return \Store\BackendBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/slider';
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // la propriété "file" peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        // utilisez le nom de fichier original ici mais
        // vous devriez "l'assainir" pour au moins éviter
        // quelconques problèmes de sécurité

        // On déplace le fichier uploadé dans le bon répertoire uploads/product
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // Je stocke le nom du fichier uploadé
        $this->image = $this->file->getClientOriginalName();

        // " nettoie " la propriété " file " comme vous n'en aurez plus besoin
        unset($this->file);
    }

    /**
     * @param \Store\BackendBundle\Entity\file $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return \Store\BackendBundle\Entity\file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->caption;
    }
}
