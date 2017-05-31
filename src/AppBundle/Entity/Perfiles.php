<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfiles
 *
 * @ORM\Table(name="perfiles")
 * @ORM\Entity
 */
class Perfiles
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre_perfil", type="string", length=75, nullable=false)
     */
    private $nombrePerfil;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_perfil", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPerfil;



    /**
     * Set nombrePerfil
     *
     * @param string $nombrePerfil
     *
     * @return Perfiles
     */
    public function setNombrePerfil($nombrePerfil)
    {
        $this->nombrePerfil = $nombrePerfil;

        return $this;
    }

    /**
     * Get nombrePerfil
     *
     * @return string
     */
    public function getNombrePerfil()
    {
        return $this->nombrePerfil;
    }

    /**
     * Get idPerfil
     *
     * @return integer
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }
}
