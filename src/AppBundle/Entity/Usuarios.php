<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios", indexes={@ORM\Index(name="perfil", columns={"perfil"})})
 * @ORM\Entity
 *
 */
class Usuarios
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre_completo", type="string", length=350, nullable=false)
     */
    private $nombreCompleto;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=false)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=false)
     */
    private $estado = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=150)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $correo;

    /**
     * @var \AppBundle\Entity\Perfiles
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Perfiles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfil", referencedColumnName="id_perfil")
     * })
     */
    private $perfil;



    /**
     * Set nombreCompleto
     *
     * @param string $nombreCompleto
     *
     * @return Usuarios
     */
    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;

        return $this;
    }

    /**
     * Get nombreCompleto
     *
     * @return string
     */
    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuarios
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     *
     * @return Usuarios
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
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set perfil
     *
     * @param \AppBundle\Entity\Perfiles $perfil
     *
     * @return Usuarios
     */
    public function setPerfil(\AppBundle\Entity\Perfiles $perfil = null)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return \AppBundle\Entity\Perfiles
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Usuarios
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }
}
