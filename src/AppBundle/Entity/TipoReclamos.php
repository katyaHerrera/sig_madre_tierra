<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoReclamos
 *
 * @ORM\Table(name="tipo_reclamos")
 * @ORM\Entity
 */
class TipoReclamos
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tiempo_atencion", type="time", nullable=false)
     */
    private $tiempoAtencion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=250, nullable=false)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tipo_reclamo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTipoReclamo;



    /**
     * Set tiempoAtencion
     *
     * @param \DateTime $tiempoAtencion
     *
     * @return TipoReclamos
     */
    public function setTiempoAtencion($tiempoAtencion)
    {
        $this->tiempoAtencion = $tiempoAtencion;

        return $this;
    }

    /**
     * Get tiempoAtencion
     *
     * @return \DateTime
     */
    public function getTiempoAtencion()
    {
        return $this->tiempoAtencion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TipoReclamos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get idTipoReclamo
     *
     * @return integer
     */
    public function getIdTipoReclamo()
    {
        return $this->idTipoReclamo;
    }
}
