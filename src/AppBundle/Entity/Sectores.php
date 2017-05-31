<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sectores
 *
 * @ORM\Table(name="sectores")
 * @ORM\Entity
 */
class Sectores
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre_sector", type="string", length=75, nullable=false)
     */
    private $nombreSector;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_sector", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSector;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Pozos", inversedBy="sector")
     * @ORM\JoinTable(name="suministros",
     *   joinColumns={
     *     @ORM\JoinColumn(name="sector", referencedColumnName="id_sector")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="pozo", referencedColumnName="id_pozo")
     *   }
     * )
     */
    private $pozo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pozo = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set nombreSector
     *
     * @param string $nombreSector
     *
     * @return Sectores
     */
    public function setNombreSector($nombreSector)
    {
        $this->nombreSector = $nombreSector;

        return $this;
    }

    /**
     * Get nombreSector
     *
     * @return string
     */
    public function getNombreSector()
    {
        return $this->nombreSector;
    }

    /**
     * Get idSector
     *
     * @return integer
     */
    public function getIdSector()
    {
        return $this->idSector;
    }

    /**
     * Add pozo
     *
     * @param \AppBundle\Entity\Pozos $pozo
     *
     * @return Sectores
     */
    public function addPozo(\AppBundle\Entity\Pozos $pozo)
    {
        $this->pozo[] = $pozo;

        return $this;
    }

    /**
     * Remove pozo
     *
     * @param \AppBundle\Entity\Pozos $pozo
     */
    public function removePozo(\AppBundle\Entity\Pozos $pozo)
    {
        $this->pozo->removeElement($pozo);
    }

    /**
     * Get pozo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPozo()
    {
        return $this->pozo;
    }
}
