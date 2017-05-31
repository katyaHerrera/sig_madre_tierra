<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResReclamos
 *
 * @ORM\Table(name="res_reclamos", indexes={@ORM\Index(name="tipo_reclamo", columns={"tipo_reclamo"})})
 * @ORM\Entity
 */
class ResReclamos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="prom_atencion", type="integer", nullable=false)
     */
    private $promAtencion;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="mes", type="integer", nullable=false)
     */
    private $mes;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio", type="integer", nullable=false)
     */
    private $anio;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_res_reclamos", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResReclamos;

    /**
     * @var \AppBundle\Entity\TipoReclamos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoReclamos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_reclamo", referencedColumnName="id_tipo_reclamo")
     * })
     */
    private $tipoReclamo;



    /**
     * Set promAtencion
     *
     * @param integer $promAtencion
     *
     * @return ResReclamos
     */
    public function setPromAtencion($promAtencion)
    {
        $this->promAtencion = $promAtencion;

        return $this;
    }

    /**
     * Get promAtencion
     *
     * @return integer
     */
    public function getPromAtencion()
    {
        return $this->promAtencion;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return ResReclamos
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return ResReclamos
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     *
     * @return ResReclamos
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Get idResReclamos
     *
     * @return integer
     */
    public function getIdResReclamos()
    {
        return $this->idResReclamos;
    }

    /**
     * Set tipoReclamo
     *
     * @param \AppBundle\Entity\TipoReclamos $tipoReclamo
     *
     * @return ResReclamos
     */
    public function setTipoReclamo(\AppBundle\Entity\TipoReclamos $tipoReclamo = null)
    {
        $this->tipoReclamo = $tipoReclamo;

        return $this;
    }

    /**
     * Get tipoReclamo
     *
     * @return \AppBundle\Entity\TipoReclamos
     */
    public function getTipoReclamo()
    {
        return $this->tipoReclamo;
    }
}
