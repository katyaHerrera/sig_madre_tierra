<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResMacromedicion
 *
 * @ORM\Table(name="res_macromedicion", indexes={@ORM\Index(name="pozo", columns={"pozo"})})
 * @ORM\Entity
 */
class ResMacromedicion
{
    /**
     * @var string
     *
     * @ORM\Column(name="total_extraido", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $totalExtraido;

    /**
     * @var string
     *
     * @ORM\Column(name="consumo_energia", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $consumoEnergia;

    /**
     * @var string
     *
     * @ORM\Column(name="costo_energia", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $costoEnergia;

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
     * @ORM\Column(name="id_res_macromedicion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResMacromedicion;

    /**
     * @var \AppBundle\Entity\Pozos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pozos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pozo", referencedColumnName="id_pozo")
     * })
     */
    private $pozo;



    /**
     * Set totalExtraido
     *
     * @param string $totalExtraido
     *
     * @return ResMacromedicion
     */
    public function setTotalExtraido($totalExtraido)
    {
        $this->totalExtraido = $totalExtraido;

        return $this;
    }

    /**
     * Get totalExtraido
     *
     * @return string
     */
    public function getTotalExtraido()
    {
        return $this->totalExtraido;
    }

    /**
     * Set consumoEnergia
     *
     * @param string $consumoEnergia
     *
     * @return ResMacromedicion
     */
    public function setConsumoEnergia($consumoEnergia)
    {
        $this->consumoEnergia = $consumoEnergia;

        return $this;
    }

    /**
     * Get consumoEnergia
     *
     * @return string
     */
    public function getConsumoEnergia()
    {
        return $this->consumoEnergia;
    }

    /**
     * Set costoEnergia
     *
     * @param string $costoEnergia
     *
     * @return ResMacromedicion
     */
    public function setCostoEnergia($costoEnergia)
    {
        $this->costoEnergia = $costoEnergia;

        return $this;
    }

    /**
     * Get costoEnergia
     *
     * @return string
     */
    public function getCostoEnergia()
    {
        return $this->costoEnergia;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return ResMacromedicion
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
     * @return ResMacromedicion
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
     * Get idResMacromedicion
     *
     * @return integer
     */
    public function getIdResMacromedicion()
    {
        return $this->idResMacromedicion;
    }

    /**
     * Set pozo
     *
     * @param \AppBundle\Entity\Pozos $pozo
     *
     * @return ResMacromedicion
     */
    public function setPozo(\AppBundle\Entity\Pozos $pozo = null)
    {
        $this->pozo = $pozo;

        return $this;
    }

    /**
     * Get pozo
     *
     * @return \AppBundle\Entity\Pozos
     */
    public function getPozo()
    {
        return $this->pozo;
    }
}
