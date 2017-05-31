<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acometidas
 *
 * @ORM\Table(name="acometidas", indexes={@ORM\Index(name="sector", columns={"sector"})})
 * @ORM\Entity
 */
class Acometidas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="acom_exist", type="integer", nullable=false)
     */
    private $acomExist;

    /**
     * @var string
     *
     * @ORM\Column(name="cub_micro", type="decimal", precision=3, scale=2, nullable=false)
     */
    private $cubMicro;

    /**
     * @var string
     *
     * @ORM\Column(name="serv_continuo", type="decimal", precision=3, scale=2, nullable=false)
     */
    private $servContinuo;

    /**
     * @var string
     *
     * @ORM\Column(name="por_activa", type="decimal", precision=3, scale=2, nullable=false)
     */
    private $porActiva;

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
     * @ORM\Column(name="id_res_acometidas", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idResAcometidas;

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
     * Set acomExist
     *
     * @param integer $acomExist
     *
     * @return Acometidas
     */
    public function setAcomExist($acomExist)
    {
        $this->acomExist = $acomExist;

        return $this;
    }

    /**
     * Get acomExist
     *
     * @return integer
     */
    public function getAcomExist()
    {
        return $this->acomExist;
    }

    /**
     * Set cubMicro
     *
     * @param string $cubMicro
     *
     * @return Acometidas
     */
    public function setCubMicro($cubMicro)
    {
        $this->cubMicro = $cubMicro;

        return $this;
    }

    /**
     * Get cubMicro
     *
     * @return string
     */
    public function getCubMicro()
    {
        return $this->cubMicro;
    }

    /**
     * Set servContinuo
     *
     * @param string $servContinuo
     *
     * @return Acometidas
     */
    public function setServContinuo($servContinuo)
    {
        $this->servContinuo = $servContinuo;

        return $this;
    }

    /**
     * Get servContinuo
     *
     * @return string
     */
    public function getServContinuo()
    {
        return $this->servContinuo;
    }

    /**
     * Set porActiva
     *
     * @param string $porActiva
     *
     * @return Acometidas
     */
    public function setPorActiva($porActiva)
    {
        $this->porActiva = $porActiva;

        return $this;
    }

    /**
     * Get porActiva
     *
     * @return string
     */
    public function getPorActiva()
    {
        return $this->porActiva;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return Acometidas
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
     * @return Acometidas
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
     * Get idResAcometidas
     *
     * @return integer
     */
    public function getIdResAcometidas()
    {
        return $this->idResAcometidas;
    }

    /**
     * Set sector
     *
     * @param \AppBundle\Entity\Sectores $sector
     *
     * @return Acometidas
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
