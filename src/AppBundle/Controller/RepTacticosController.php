<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * @Route("/reportes-tacticos")
 */
class RepTacticosController extends Controller
{
    private $meses = array("Enero" => 1,
        "Febrero" => 2,
        "Marzo" => 3,
        "Abril" => 4,
        "Mayo" => 5,
        "Junio" => 6,
        "Julio" => 7,
        "Agosto" => 8,
        "Septiembre" => 9,
        "Octubre" => 10,
        "Noviembre" => 11,
        "Diciembre" => 12);

    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/consumo-agua", name="consumo_agua")
     * @Method({"GET", "POST"})
     */
    public function consumoAguaAction(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $stmnt = $conn->prepare("SELECT id_tarifa, CONCAT(consumo_min, '-', consumo_max) rango FROM tarifas");
        $stmnt->execute();

        $result = $stmnt->fetchAll();

        $tarifas = array_combine(array_column($result, "rango"), array_column($result, "id_tarifa"));


        $capturaDatos = array();
        $form = $this->createFormBuilder($capturaDatos)
            ->add("periodo", ChoiceType::class, array(
                "choices"=>array(
                    "Mensual" => 1,
                    "Trimestral" => 3,
                    "Semestral" => 6,
                    "Anual" => 12
                ),
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un período"))
            ))
            ->add('mesInicio', ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Inicio"))
            ))
            ->add('anioInicio', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de inicio")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )
            ))
            ->add("mesFin", ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Fin"))
            ))
            ->add('anioFin', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de fin")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('tarifa', ChoiceType::class, array(
                "choices" => $tarifas,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un rango de tarifa"))

            ))
            ->add('tipo_cliente', ChoiceType::class, array(
                "choices" => array(
                    "Comercial" => 1,
                    "Residencial" => 2,
                    "Todos" => 0
                ),
                "expanded" => true,
                "multiple" => false
            ))
            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
        }

        return $this->render('RepTacticos/rep_semi_res_consumo_agua.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte semi-resumen de Consumo de Agua por rango de Tarifa"
        ));

    }


    /**
     * @Route("/eficiencia-fisica", name="eficiencia_fisica")
     * @Method({"GET", "POST"})
     */
    public function eficienciaFisicaAction(Request $request){
        $capturaDatos = array();
        $form = $this->createFormBuilder($capturaDatos)
            ->add("periodo", ChoiceType::class, array(
                "choices"=>array(
                    "Mensual" => 1,
                    "Trimestral" => 3,
                    "Semestral" => 6,
                    "Anual" => 12
                ),
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un período"))
            ))
            ->add('mesInicio', ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Inicio"))
            ))
            ->add('anioInicio', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de inicio")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )
            ))
            ->add("mesFin", ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Fin"))
            ))
            ->add('anioFin', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de fin")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
        }

        return $this->render('RepTacticos/rep_semi_res_eficiencia_fisica.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte semi-resumen de indicador de eficiencia fisica"
        ));
    }

    /**
     * @Route("/indicador-energetico", name="indicador_energetico")
     * @Method({"GET", "POST"})
     */
    public function indicadorEnergeticoAction(Request $request){
        $capturaDatos = array();
        $form = $this->createFormBuilder($capturaDatos)
            ->add("periodo", ChoiceType::class, array(
                "choices"=>array(
                    "Mensual" => 1,
                    "Trimestral" => 3,
                    "Semestral" => 6,
                    "Anual" => 12
                ),
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un período"))
            ))
            ->add('mesInicio', ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Inicio"))
            ))
            ->add('anioInicio', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de inicio")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )
            ))
            ->add("mesFin", ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Fin"))
            ))
            ->add('anioFin', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de fin")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
        }

        return $this->render('RepTacticos/rep_semi_res_eficiencia_fisica.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte semi-resumen de indicador energetico"
        ));
    }

    /**
     * @Route("/dotacion-habitante", name="dotacion_habitante")
     * @Method({"GET", "POST"})
     */
    public function dotacionHabitanteAction(Request $request){
        $capturaDatos = array();
        $form = $this->createFormBuilder($capturaDatos)
            ->add("periodo", ChoiceType::class, array(
                "choices"=>array(
                    "Mensual" => 1,
                    "Trimestral" => 3,
                    "Semestral" => 6,
                    "Anual" => 12
                ),
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un período"))
            ))
            ->add('mesInicio', ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Inicio"))
            ))
            ->add('anioInicio', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de inicio")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )
            ))
            ->add("mesFin", ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Fin"))
            ))
            ->add('anioFin', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de fin")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
        }

        return $this->render('RepTacticos/rep_semi_res_eficiencia_fisica.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte semi-resumen de dotación de agua disponible 
            por habitante"
        ));
    }

    /**
     * @Route("/acometidas-activas", name="acom_activas")
     * @Method({"GET", "POST"})
     */
    public function acometidasActivasAction(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $stmnt = $conn->prepare("SELECT id_sector, nombre_sector FROM sectores");
        $stmnt->execute();

        $result = $stmnt->fetchAll();

        $sectores = array("Todos" => 0) +
            array_combine(array_column($result, "nombre_sector"), array_column($result, "id_sector"));

        $capturaDatos = array();
        $form = $this->createFormBuilder($capturaDatos)
            ->add("sector", ChoiceType::class, array(
                "choices" => $sectores,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un sector"))
            ))
            ->add("periodo", ChoiceType::class, array(
                "choices"=>array(
                    "Mensual" => 1,
                    "Trimestral" => 3,
                    "Semestral" => 6,
                    "Anual" => 12
                ),
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un período"))
            ))
            ->add('mesInicio', ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Inicio"))
            ))
            ->add('anioInicio', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de inicio")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )
            ))
            ->add("mesFin", ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Fin"))
            ))
            ->add('anioFin', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de fin")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
        }

        return $this->render('RepTacticos/rep_semi_res_acom_activas.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte semi-resumen de acometidas activas"
        ));
    }

    /**
     * @Route("/mayor-consumo", name="mayor_consumo")
     * @Method({"GET", "POST"})
     */
    public function mayorConsumoAction(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $stmnt = $conn->prepare("SELECT id_sector, nombre_sector FROM sectores");
        $stmnt->execute();

        $result = $stmnt->fetchAll();

        $sectores = array("Todos" => 0) +
            array_combine(array_column($result, "nombre_sector"), array_column($result, "id_sector"));

        $capturaDatos = array();
        $form = $this->createFormBuilder($capturaDatos)
            ->add("sector", ChoiceType::class, array(
                "choices" => $sectores,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un sector"))
            ))
            ->add("periodo", ChoiceType::class, array(
                "choices"=>array(
                    "Mensual" => 1,
                    "Trimestral" => 3,
                    "Semestral" => 6,
                    "Anual" => 12
                ),
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un período"))
            ))
            ->add('mesInicio', ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Inicio"))
            ))
            ->add('anioInicio', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de inicio")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )
            ))
            ->add("mesFin", ChoiceType::class, array(
                "choices"=> $this->meses,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un Mes de Fin"))
            ))
            ->add('anioFin', TextType::class, array(
                "constraints" => array(
                    new NotBlank(array("message" => "Por favor ingrese una año de fin")),
                    new Regex(array("pattern" => "^\\d+$",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
        }

        return $this->render('RepTacticos/rep_semi_res_acom_activas.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte semi-resumen de clientes con mayor consumo"
        ));
    }
}
