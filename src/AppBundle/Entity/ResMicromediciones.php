<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResMicromediciones
 *
 * @ORM\Table(name="res_micromediciones", indexes={@ORM\Index(name="sector", columns={"sector"}), @ORM\Index(name="tarifa", columns={"tarifa"})})
 * @ORM\Entity
 */
class ResMicromediciones
{
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
     * @var string
     *
     * @ORM\Column(name="total_consumo", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $totalConsumo;

    /**
     * @var string
     *
     * @ORM\Column(name="monto_facturado", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $montoFacturado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_res_micromedicion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResMicromedicion;

    /**
     * @var \AppBundle\Entity\Tarifas
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tarifas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tarifa", referencedColumnName="id_tarifa")
     * })
     */
    private $tarifa;

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
     * Set mes
     *
     * @param integer $mes
     *
     * @return ResMicromediciones
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
     * @return ResMicromediciones
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
     * @return ResMicromediciones
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
     * Set totalConsumo
     *
     * @param string $totalConsumo
     *
     * @return ResMicromediciones
     */
    public function setTotalConsumo($totalConsumo)
    {
        $this->totalConsumo = $totalConsumo;

        return $this;
    }

    /**
     * Get totalConsumo
     *
     * @return string
     */
    public function getTotalConsumo()
    {
        return $this->totalConsumo;
    }

    /**
     * Set montoFacturado
     *
     * @param string $montoFacturado
     *
     * @return ResMicromediciones
     */
    public function setMontoFacturado($montoFacturado)
    {
        $this->montoFacturado = $montoFacturado;

        return $this;
    }

    /**
     * Get montoFacturado
     *
     * @return string
     */
    public function getMontoFacturado()
    {
        return $this->montoFacturado;
    }

    /**
     * Get idResMicromedicion
     *
     * @return integer
     */
    public function getIdResMicromedicion()
    {
        return $this->idResMicromedicion;
    }

    /**
     * Set tarifa
     *
     * @param \AppBundle\Entity\Tarifas $tarifa
     *
     * @return ResMicromediciones
     */
    public function setTarifa(\AppBundle\Entity\Tarifas $tarifa = null)
    {
        $this->tarifa = $tarifa;

        return $this;
    }

    /**
     * Get tarifa
     *
     * @return \AppBundle\Entity\Tarifas
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }

    /**
     * Set sector
     *
     * @param \AppBundle\Entity\Sectores $sector
     *
     * @return ResMicromediciones
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
