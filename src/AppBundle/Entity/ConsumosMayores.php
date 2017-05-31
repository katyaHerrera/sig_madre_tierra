<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsumosMayores
 *
 * @ORM\Table(name="consumos_mayores", indexes={@ORM\Index(name="sector", columns={"sector"})})
 * @ORM\Entity
 */
class ConsumosMayores
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre_cliente", type="string", length=350, nullable=false)
     */
    private $nombreCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=500, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="consumo", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $consumo;

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
     * @ORM\Column(name="tipo_acometida", type="integer", nullable=false)
     */
    private $tipoAcometida;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_reg", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReg;

    /**
     * @var \AppBundle\Entity\Sectores
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sectores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sector", referencedColumnName="id_sector")
     * })
     */
    private $sector;



    /**
     * Set nombreCliente
     *
     * @param string $nombreCliente
     *
     * @return ConsumosMayores
     */
    public function setNombreCliente($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;

        return $this;
    }

    /**
     * Get nombreCliente
     *
     * @return string
     */
    public function getNombreCliente()
    {
        return $this->nombreCliente;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return ConsumosMayores
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set consumo
     *
     * @param string $consumo
     *
     * @return ConsumosMayores
     */
    public function setConsumo($consumo)
    {
        $this->consumo = $consumo;

        return $this;
    }

    /**
     * Get consumo
     *
     * @return string
     */
    public function getConsumo()
    {
        return $this->consumo;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return ConsumosMayores
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
     * @return ConsumosMayores
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
     * Set tipoAcometida
     *
     * @param integer $tipoAcometida
     *
     * @return ConsumosMayores
     */
    public function setTipoAcometida($tipoAcometida)
    {
        $this->tipoAcometida = $tipoAcometida;

        return $this;
    }

    /**
     * Get tipoAcometida
     *
     * @return integer
     */
    public function getTipoAcometida()
    {
        return $this->tipoAcometida;
    }

    /**
     * Get idReg
     *
     * @return integer
     */
    public function getIdReg()
    {
        return $this->idReg;
    }

    /**
     * Set sector
     *
     * @param \AppBundle\Entity\Sectores $sector
     *
     * @return ConsumosMayores
     */
    public function setSector(\AppBundle\Entity\Sectores $sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \AppBundle\Entity\Sectores
     */
    public function getSector()
    {
        return $this->sector;
    }
}
