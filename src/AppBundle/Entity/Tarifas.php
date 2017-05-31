<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarifas
 *
 * @ORM\Table(name="tarifas")
 * @ORM\Entity
 */
class Tarifas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="nivel", type="integer", nullable=false)
     */
    private $nivel;

    /**
     * @var string
     *
     * @ORM\Column(name="consumo_min", type="decimal", precision=7, scale=2, nullable=false)
     */
    private $consumoMin;

    /**
     * @var string
     *
     * @ORM\Column(name="consumo_max", type="decimal", precision=7, scale=2, nullable=false)
     */
    private $consumoMax;

    /**
     * @var string
     *
     * @ORM\Column(name="cobro", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $cobro;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_tarifa", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTarifa;



    /**
     * Set nivel
     *
     * @param integer $nivel
     *
     * @return Tarifas
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set consumoMin
     *
     * @param string $consumoMin
     *
     * @return Tarifas
     */
    public function setConsumoMin($consumoMin)
    {
        $this->consumoMin = $consumoMin;

        return $this;
    }

    /**
     * Get consumoMin
     *
     * @return string
     */
    public function getConsumoMin()
    {
        return $this->consumoMin;
    }

    /**
     * Set consumoMax
     *
     * @param string $consumoMax
     *
     * @return Tarifas
     */
    public function setConsumoMax($consumoMax)
    {
        $this->consumoMax = $consumoMax;

        return $this;
    }

    /**
     * Get consumoMax
     *
     * @return string
     */
    public function getConsumoMax()
    {
        return $this->consumoMax;
    }

    /**
     * Set cobro
     *
     * @param string $cobro
     *
     * @return Tarifas
     */
    public function setCobro($cobro)
    {
        $this->cobro = $cobro;

        return $this;
    }

    /**
     * Get cobro
     *
     * @return string
     */
    public function getCobro()
    {
        return $this->cobro;
    }

    /**
     * Get idTarifa
     *
     * @return integer
     */
    public function getIdTarifa()
    {
        return $this->idTarifa;
    }
}
