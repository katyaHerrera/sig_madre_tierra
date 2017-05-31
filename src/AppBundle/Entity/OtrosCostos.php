<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtrosCostos
 *
 * @ORM\Table(name="otros_costos")
 * @ORM\Entity
 */
class OtrosCostos
{
    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $total;

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
     * @ORM\Column(name="id_reg_otros_costos", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRegOtrosCostos;



    /**
     * Set total
     *
     * @param string $total
     *
     * @return OtrosCostos
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return OtrosCostos
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
     * @return OtrosCostos
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
     * Get idRegOtrosCostos
     *
     * @return integer
     */
    public function getIdRegOtrosCostos()
    {
        return $this->idRegOtrosCostos;
    }
}
