<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pozos
 *
 * @ORM\Table(name="pozos")
 * @ORM\Entity
 */
class Pozos
{
    /**
     * @var string
     *
     * @ORM\Column(name="ubicacion", type="string", length=500, nullable=false)
     */
    private $ubicacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_pozo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPozo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Sectores", mappedBy="pozo")
     */
    private $sector;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sector = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     *
     * @return Pozos
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Get idPozo
     *
     * @return integer
     */
    public function getIdPozo()
    {
        return $this->idPozo;
    }

    /**
     * Add sector
     *
     * @param \AppBundle\Entity\Sectores $sector
     *
     * @return Pozos
     */
    public function addSector(\AppBundle\Entity\Sectores $sector)
    {
        $this->sector[] = $sector;

        return $this;
    }

    /**
     * Remove sector
     *
     * @param \AppBundle\Entity\Sectores $sector
     */
    public function removeSector(\AppBundle\Entity\Sectores $sector)
    {
        $this->sector->removeElement($sector);
    }

    /**
     * Get sector
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSector()
    {
        return $this->sector;
    }
}
