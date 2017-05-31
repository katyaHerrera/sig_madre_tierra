<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResFacturacion
 *
 * @ORM\Table(name="res_facturacion")
 * @ORM\Entity
 */
class ResFacturacion
{
    /**
     * @var string
     *
     * @ORM\Column(name="monto_recaudado", type="decimal", precision=18, scale=2, nullable=false)
     */
    private $montoRecaudado;

    /**
     * @var \AppBundle\Entity\ResMicromediciones
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ResMicromediciones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_res_micromedicion", referencedColumnName="id_res_micromedicion")
     * })
     */
    private $idResMicromedicion;



    /**
     * Set montoRecaudado
     *
     * @param string $montoRecaudado
     *
     * @return ResFacturacion
     */
    public function setMontoRecaudado($montoRecaudado)
    {
        $this->montoRecaudado = $montoRecaudado;

        return $this;
    }

    /**
     * Get montoRecaudado
     *
     * @return string
     */
    public function getMontoRecaudado()
    {
        return $this->montoRecaudado;
    }

    /**
     * Set idResMicromedicion
     *
     * @param \AppBundle\Entity\ResMicromediciones $idResMicromedicion
     *
     * @return ResFacturacion
     */
    public function setIdResMicromedicion(\AppBundle\Entity\ResMicromediciones $idResMicromedicion)
    {
        $this->idResMicromedicion = $idResMicromedicion;

        return $this;
    }

    /**
     * Get idResMicromedicion
     *
     * @return \AppBundle\Entity\ResMicromediciones
     */
    public function getIdResMicromedicion()
    {
        return $this->idResMicromedicion;
    }
}
