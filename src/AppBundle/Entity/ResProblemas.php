<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResProblemas
 *
 * @ORM\Table(name="res_problemas", indexes={@ORM\Index(name="sector", columns={"sector"})})
 * @ORM\Entity
 */
class ResProblemas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cant_rebalses", type="integer", nullable=false)
     */
    private $cantRebalses;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_con_ilegal", type="integer", nullable=false)
     */
    private $cantConIlegal;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_rotura", type="integer", nullable=false)
     */
    private $cantRotura;

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
     * @ORM\Column(name="id_reg_problemas", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRegProblemas;

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
     * Set cantRebalses
     *
     * @param integer $cantRebalses
     *
     * @return ResProblemas
     */
    public function setCantRebalses($cantRebalses)
    {
        $this->cantRebalses = $cantRebalses;

        return $this;
    }

    /**
     * Get cantRebalses
     *
     * @return integer
     */
    public function getCantRebalses()
    {
        return $this->cantRebalses;
    }

    /**
     * Set cantConIlegal
     *
     * @param integer $cantConIlegal
     *
     * @return ResProblemas
     */
    public function setCantConIlegal($cantConIlegal)
    {
        $this->cantConIlegal = $cantConIlegal;

        return $this;
    }

    /**
     * Get cantConIlegal
     *
     * @return integer
     */
    public function getCantConIlegal()
    {
        return $this->cantConIlegal;
    }

    /**
     * Set cantRotura
     *
     * @param integer $cantRotura
     *
     * @return ResProblemas
     */
    public function setCantRotura($cantRotura)
    {
        $this->cantRotura = $cantRotura;

        return $this;
    }

    /**
     * Get cantRotura
     *
     * @return integer
     */
    public function getCantRotura()
    {
        return $this->cantRotura;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return ResProblemas
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
     * @return ResProblemas
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
     * Get idRegProblemas
     *
     * @return integer
     */
    public function getIdRegProblemas()
    {
        return $this->idRegProblemas;
    }

    /**
     * Set sector
     *
     * @param \AppBundle\Entity\Sectores $sector
     *
     * @return ResProblemas
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
