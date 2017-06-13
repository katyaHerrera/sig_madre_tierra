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
 * @Route("/reportes-estrategicos")
 */
class RepEstrategicosController extends Controller
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
     * @Route("/eficiencia-global-comercial", name="efiGlobalComercial")
     * @Method({"GET", "POST"})
     */
    public function eficienciaComGloActtion(Request $request){
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

        return $this->render('RepEstrategicos/rep_res_eficiencia_com_glo.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte de Indicadores de Eficiencia Global y Comercial"
        ));

    }

    /**
     * @Route("/indicador-rentabilidad", name="rentabilidad")
     * @Method({"GET", "POST"})
     */
    public function indRentabilidadAction(Request $request){
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

        return $this->render('RepEstrategicos/rep_res_eficiencia_com_glo.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte de Indicador de Rentabilidad"
        ));
    }

    /**
     * @Route("/cont-servicio", name="cont_servicio")
     * @Method({"GET", "POST"})
     */
    public function contServicioAction(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $stmnt = $conn->prepare("SELECT id_sector, nombre_sector FROM sectores");
        $stmnt->execute();

        $result = $stmnt->fetchAll();

        $sectores = array_combine(array_column($result, "nombre_sector"), array_column($result, "id_sector"));

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

        return $this->render('RepEstrategicos/rep_cont_servicio.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte de Indicador de Continuidad del Servicio"
        ));
    }

    /**
     * @Route("/cob-micromedicion", name="cob_micromedicion")
     * @Method({"GET", "POST"})
     */
    public function cobMicrommedicion(Request $request){
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

        return $this->render('RepEstrategicos/rep_cont_servicio.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte de Indicador de Cobertura de Micromedición"
        ));
    }


    /**
     * @Route("/resp-reclamos", name="reclamos")
     * @Method({"GET", "POST"})
     */
    public function respReclamosAction(Request $request){
        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $stmnt = $conn->prepare("SELECT id_tipo_reclamo, descripcion FROM tipo_reclamos");
        $stmnt->execute();

        $result = $stmnt->fetchAll();

        $reclamos = array_combine(array_column($result, "descripcion"), array_column($result, "id_tipo_reclamo"));

        $capturaDatos = array();
        $form = $this->createFormBuilder($capturaDatos)
            ->add("tipo_reclamo", ChoiceType::class, array(
                "choices" => $reclamos,
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un tipo de reclamo"))
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

        return $this->render('RepEstrategicos/rep_resp_reclamos.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte de Indicador de Tiempo de Respuesta a Reclamos"
        ));
    }

}
