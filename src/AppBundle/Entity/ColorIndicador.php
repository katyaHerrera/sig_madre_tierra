<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ColorIndicador
 *
 * @ORM\Table(name="color_indicador")
 * @ORM\Entity
 */
class ColorIndicador
{
    /**
     * @var string
     *
     * @ORM\Column(name="valor_verde", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorVerde;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_amarillo", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorAmarillo;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_anaranjado", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $valorAnaranjado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ascen_bueno", type="boolean", nullable=true)
     */
    private $ascenBueno = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="nom_indicador", type="string", length=75, nullable=false)
     */
    private $nomIndicador;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_indicador", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idIndicador;



    /**
     * Set valorVerde
     *
     * @param string $valorVerde
     *
     * @return ColorIndicador
     */
    public function setValorVerde($valorVerde)
    {
        $this->valorVerde = $valorVerde;

        return $this;
    }

    /**
     * Get valorVerde
     *
     * @return string
     */
    public function getValorVerde()
    {
        return $this->valorVerde;
    }

    /**
     * Set valorAmarillo
     *
     * @param string $valorAmarillo
     *
     * @return ColorIndicador
     */
    public function setValorAmarillo($valorAmarillo)
    {
        $this->valorAmarillo = $valorAmarillo;

        return $this;
    }

    /**
     * Get valorAmarillo
     *
     * @return string
     */
    public function getValorAmarillo()
    {
        return $this->valorAmarillo;
    }

    /**
     * Set valorAnaranjado
     *
     * @param string $valorAnaranjado
     *
     * @return ColorIndicador
     */
    public function setValorAnaranjado($valorAnaranjado)
    {
        $this->valorAnaranjado = $valorAnaranjado;

        return $this;
    }

    /**
     * Get valorAnaranjado
     *
     * @return string
     */
    public function getValorAnaranjado()
    {
        return $this->valorAnaranjado;
    }

    /**
     * Set ascenBueno
     *
     * @param boolean $ascenBueno
     *
     * @return ColorIndicador
     */
    public function setAscenBueno($ascenBueno)
    {
        $this->ascenBueno = $ascenBueno;

        return $this;
    }

    /**
     * Get ascenBueno
     *
     * @return boolean
     */
    public function getAscenBueno()
    {
        return $this->ascenBueno;
    }

    /**
     * Set nomIndicador
     *
     * @param string $nomIndicador
     *
     * @return ColorIndicador
     */
    public function setNomIndicador($nomIndicador)
    {
        $this->nomIndicador = $nomIndicador;

        return $this;
    }

    /**
     * Get nomIndicador
     *
     * @return string
     */
    public function getNomIndicador()
    {
        return $this->nomIndicador;
    }

    /**
     * Get idIndicador
     *
     * @return integer
     */
    public function getIdIndicador()
    {
        return $this->idIndicador;
    }
}
