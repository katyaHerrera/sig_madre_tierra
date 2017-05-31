<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecPassword
 *
 * @ORM\Table(name="rec_password", indexes={@ORM\Index(name="usuario", columns={"usuario"})})
 * @ORM\Entity
 */
class RecPassword
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date", nullable=false)
     */
    private $fechaRegistro;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ram_link", type="string", length=75, nullable=false)
     */
    private $ramLink;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_rec_password", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRecPassword;

    /**
     * @var \AppBundle\Entity\Usuarios
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="correo")
     * })
     */
    private $usuario;



    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return RecPassword
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     *
     * @return RecPassword
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set ramLink
     *
     * @param string $ramLink
     *
     * @return RecPassword
     */
    public function setRamLink($ramLink)
    {
        $this->ramLink = $ramLink;

        return $this;
    }

    /**
     * Get ramLink
     *
     * @return string
     */
    public function getRamLink()
    {
        return $this->ramLink;
    }

    /**
     * Get idRecPassword
     *
     * @return integer
     */
    public function getIdRecPassword()
    {
        return $this->idRecPassword;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuarios $usuario
     *
     * @return RecPassword
     */
    public function setUsuario(\AppBundle\Entity\Usuarios $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuarios
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
