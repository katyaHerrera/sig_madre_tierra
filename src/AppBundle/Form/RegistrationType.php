<?php
/**
 * Created by PhpStorm.
 * User: cgcomputadoras
 * Date: 5/6/2017
 * Time: 10:41 AM
 */

namespace AppBundle\Form;


use AppBundle\Services\RolesHelper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    private $roles;
    private $roleHierarchy;
    private $theRoles;


    public function __construct(ContainerInterface $container)
    {
        $this->roleHierarchy = $container->getParameter('security.role_hierarchy.roles');
        print_r($this->roles);

        $this->theRoles = array_keys($this->roleHierarchy);

        foreach ($this->theRoles as $role) {
            $theRoles[$role] = $role;
        }

        $this->roles=array(
          'ESTRATEGICO'=>$this->theRoles[0],
          'TACTICO'=>$this->theRoles[1],
          'ADMINISTRADOR'=>$this->theRoles[2]
        );

    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('nombres',TextType::class)
           ->add('apellidos',TextType::class)
           ->add('roles',ChoiceType::class, array(
               'choices'  => $this->roles,
               'expanded'  => true,
               'multiple'  => true,
               'required' => false,
           ));


        ;
    }
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}