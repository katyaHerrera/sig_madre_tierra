<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
                    new Regex(array("pattern" => "/^[0-9]+$/",
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
                    new Regex(array("pattern" => "/^[0-9]+$/",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('send', SubmitType::class, array("label"=>"Preview"))
            ->add('pdf', SubmitType::class, array("label" => "Crear PDF"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
            $diff = ($data["anioFin"] * 12 + array_search($data["mesFin"], $this->meses))
                - ($data["anioInicio"] * 12 + array_search($data["mesInicio"], $this->meses));

            if ($diff >= 0) {
                $conn = $this->getDoctrine()->getManager()->getConnection();
                $stmntConsumido = $conn->prepare("SELECT micro.anio, (FLOOR((micro.mes -1 ) / :periodo) + 1) periodo, 
                                              SUM(micro.total_consumo) consumido
                                              FROM res_micromediciones micro
                                              WHERE (micro.anio * 12 + micro.mes) >= (:anioInicio * 12 + :mesInicio) AND 
                                              (micro.anio * 12 + micro.mes) <= (:anioFin * 12 + :mesFin)
                                              GROUP BY micro.anio, FLOOR((micro.mes - 1) / :periodo)
                                              ORDER BY micro.anio, periodo");

                $stmntExtraido = $conn->prepare("SELECT macro.anio, (FLOOR((macro.mes -1 ) / :periodo) + 1) periodo, 
                                            SUM(macro.total_extraido) extraido
                                            FROM res_macromedicion macro
                                            WHERE (macro.anio * 12 + macro.mes) >= (:anioInicio * 12 + :mesInicio) AND 
                                            (macro.anio * 12 + macro.mes) <= (:anioFin * 12 + :mesFin)
                                            GROUP BY macro.anio, FLOOR((macro.mes - 1) / :periodo)
                                            ORDER BY macro.anio, periodo");

                $stmntFacturacion = $conn->prepare("SELECT SUM(fac.monto_facturado) facturado, 
                                                SUM(fac.monto_recaudado) recaudado, fac.anio, 
                                                (FLOOR((fac.mes -1 ) / :periodo) + 1) periodo
                                                FROM res_facturacion fac
                                                WHERE (fac.anio * 12 + fac.mes) >= (:anioInicio *12 + :mesInicio) AND 
                                                (fac.anio * 12 + fac.mes) <= (:anioFin * 12 + :mesFin)
                                                GROUP BY fac.anio, FLOOR((fac.mes - 1) / :periodo)
                                                ORDER BY  fac.anio, periodo;");

                $stmntConsumido->bindValue("periodo", $data["periodo"]);
                $stmntConsumido->bindValue("anioInicio", $data["anioInicio"]);
                $stmntConsumido->bindValue("mesInicio", $data["mesInicio"]);
                $stmntConsumido->bindValue("anioFin", $data["anioFin"]);
                $stmntConsumido->bindValue("mesFin", $data["mesFin"]);

                $stmntExtraido->bindValue("periodo", $data["periodo"]);
                $stmntExtraido->bindValue("anioInicio", $data["anioInicio"]);
                $stmntExtraido->bindValue("mesInicio", $data["mesInicio"]);
                $stmntExtraido->bindValue("anioFin", $data["anioFin"]);
                $stmntExtraido->bindValue("mesFin", $data["mesFin"]);

                $stmntFacturacion->bindValue("periodo", $data["periodo"]);
                $stmntFacturacion->bindValue("anioInicio", $data["anioInicio"]);
                $stmntFacturacion->bindValue("mesInicio", $data["mesInicio"]);
                $stmntFacturacion->bindValue("anioFin", $data["anioFin"]);
                $stmntFacturacion->bindValue("mesFin", $data["mesFin"]);

                $stmntFacturacion->execute();
                $stmntExtraido->execute();
                $stmntConsumido->execute();

                $resultConsumido = $stmntConsumido->fetchAll();
                $resultExtraido = $stmntExtraido->fetchAll();
                $resultFacturacion = $stmntFacturacion->fetchAll();

                $res = array();

                for ($i = 0; $i < count($resultConsumido); $i++) {
                    $comercial = $resultFacturacion[$i]["recaudado"] / $resultFacturacion[$i]["facturado"];
                    $fisica = $resultConsumido[$i]["consumido"] / $resultExtraido[$i]["extraido"];
                    $global = $fisica * $comercial;

                    $res[] = array("facturado" => $resultFacturacion[$i]["facturado"],
                        "recaudado" => $resultFacturacion[$i]["recaudado"], "comercial" => $comercial,
                        "global" => $global, "periodo" => $resultFacturacion[$i]["periodo"],
                        "anio" => $resultFacturacion[$i]["anio"]);
                }

                $tipoPeriodo = "Ninguno";
                if ($data["periodo"] == 1) {
                    $tipoPeriodo = "Mes";
                } elseif ($data["periodo"] == 3) {
                    $tipoPeriodo = "Trimestre";
                } elseif ($data["periodo"] == 6) {
                    $tipoPeriodo = "Semestre";
                } elseif ($data["periodo"] == 12) {
                    $tipoPeriodo = "Año";
                }

                $periodoInicio = array_search($data["mesInicio"], $this->meses) . " " . $data["anioInicio"];
                $periodoFin = array_search($data["mesFin"], $this->meses) . " " . $data["anioFin"];
                $now = date("d/m/Y");

                if ($form->get("pdf")->isClicked()) {

                    $snappy = $this->get("knp_snappy.pdf");
                    $html = $this->renderView("RepEstrategicos/Reportes/reporte_eficiencia_global_fisca.html.twig",
                        array("data" => $res, "tipoPeriodo" => $tipoPeriodo, "today" => $now,
                            "periodoInicio" => $periodoInicio, "periodoFin" => $periodoFin));

                    $filename = "reportePDF";

                    return new Response(
                        $snappy->getOutputFromHtml($html),
                        200,
                        array(
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'inline; filename="' . $filename . '.pdf"'
                        )
                    );
                } else if ($form->get("send")->isClicked()) {
                    return $this->render('RepEstrategicos/CapturaDatos/PreviewTables/preview_eficiencia_com_glo.html.twig', array(
                        'form' => $form->createView(), "pageHeader" => "Reporte de Indicadores de Eficiencia Global y Comercial",
                        "data" => $res, "tipoPeriodo" => $tipoPeriodo
                    ));
                }

            }
            else{
                $form->addError(new FormError("La fecha de inicio no puede ser mayor a la fecha de Fin"));
                return $this->render('RepEstrategicos/CapturaDatos/rep_res_eficiencia_com_glo.html.twig', array(
                    'form' => $form->createView(), "pageHeader" => "Reporte de Indicadores de Eficiencia Global y Comercial"
                ));
            }
        }

        return $this->render('RepEstrategicos/CapturaDatos/rep_res_eficiencia_com_glo.html.twig', array(
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
                    new Regex(array("pattern" => "/^[0-9]+$/",
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
                    new Regex(array("pattern" => "/^[0-9]+$/",
                        "message" => "El valor ingresado no es año válido"
                    ))
                )))
            ->add('send', SubmitType::class, array("label"=>"Preview"))
            ->add('pdf', SubmitType::class, array("label" => "Crear PDF"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
            $conn = $this->getDoctrine()->getManager()->getConnection();
            $recaudado = $conn->prepare("SELECT fac.anio, (FLOOR((fac.mes -1 ) / :periodo) + 1) periodo, 
                                              SUM(fac.monto_recaudado) recaudado
                                              FROM res_facturacion fac
                                              WHERE (fac.anio * 12 + fac.mes) >= (:anioInicio * 12 + :mesInicio) AND 
                                              (fac.anio * 12 + fac.mes) <= (:anioFin * 12 + :mesFin)
                                              GROUP BY fac.anio, FLOOR((fac.mes - 1) / :periodo)
                                              ORDER BY fac.anio, periodo");
            $otrosCostos = $conn->prepare("SELECT costos.anio, (FLOOR((costos.mes -1 ) / :periodo) + 1) periodo, 
                                              SUM(costos.total) otrosCostos
                                              FROM otros_costos costos
                                              WHERE (costos.anio * 12 + costos.mes) >= (:anioInicio * 12 + :mesInicio) AND 
                                              (costos.anio * 12 + costos.mes) <= (:anioFin * 12 + :mesFin)
                                              GROUP BY costos.anio, FLOOR((costos.mes - 1) / :periodo)
                                              ORDER BY costos.anio, periodo");

            $costosEnergia = $conn->prepare("SELECT costos.anio, (FLOOR((costos.mes -1 ) / :periodo) + 1) periodo, 
                                              SUM(costos.costo_energia) costosEnergia
                                              FROM res_macromedicion costos
                                              WHERE (costos.anio * 12 + costos.mes) >= (:anioInicio * 12 + :mesInicio) AND 
                                              (costos.anio * 12 + costos.mes) <= (:anioFin * 12 + :mesFin)
                                              GROUP BY costos.anio, FLOOR((costos.mes - 1) / :periodo)
                                              ORDER BY costos.anio, periodo");

            $recaudado->bindValue("periodo", $data["periodo"]);
            $recaudado->bindValue("anioInicio", $data["anioInicio"]);
            $recaudado->bindValue("mesInicio", $data["mesInicio"]);
            $recaudado->bindValue("anioFin", $data["anioFin"]);
            $recaudado->bindValue("mesFin", $data["mesFin"]);

            $otrosCostos->bindValue("periodo", $data["periodo"]);
            $otrosCostos->bindValue("anioInicio", $data["anioInicio"]);
            $otrosCostos->bindValue("mesInicio", $data["mesInicio"]);
            $otrosCostos->bindValue("anioFin", $data["anioFin"]);
            $otrosCostos->bindValue("mesFin", $data["mesFin"]);

            $costosEnergia->bindValue("periodo", $data["periodo"]);
            $costosEnergia->bindValue("anioInicio", $data["anioInicio"]);
            $costosEnergia->bindValue("mesInicio", $data["mesInicio"]);
            $costosEnergia->bindValue("anioFin", $data["anioFin"]);
            $costosEnergia->bindValue("mesFin", $data["mesFin"]);

            $recaudado->execute();
            $otrosCostos->execute();
            $costosEnergia->execute();

            $resultRecaudado = $recaudado->fetchAll();
            $resultOtrosCostos = $otrosCostos->fetchAll();
            $resultCostosEnergia = $costosEnergia->fetchAll();

            $res = array();

            for ($i = 0; $i < count($resultOtrosCostos); $i++)
            {
                $costos = $resultOtrosCostos[$i]["otrosCostos"] + $resultCostosEnergia[$i]["costosEnergia"];
                $rent=($resultRecaudado[$i]["recaudado"]-$costos);
                $rentabilidad=($rent/$resultRecaudado[$i]["recaudado"]);

                $res[] = array("costosTotales" => $costos,
                    "recaudado" => $resultRecaudado[$i]["recaudado"], "rentabilidad" => $rentabilidad,
                    "periodo" => $resultRecaudado[$i]["periodo"],
                    "anio" => $resultRecaudado[$i]["anio"]);
            }

            $tipoPeriodo = "Ninguno";
            if ($data["periodo"] == 1){
                $tipoPeriodo = "Mes";
            }
            elseif ($data["periodo"] == 3){
                $tipoPeriodo = "Trimestre";
            }
            elseif ($data["periodo"] == 6){
                $tipoPeriodo = "Semestre";
            }
            elseif ($data["periodo"] == 12){
                $tipoPeriodo = "Año";
            }

            $periodoInicio = array_search($data["mesInicio"], $this->meses) . " " . $data["anioInicio"];
            $periodoFin = array_search($data["mesFin"], $this->meses) . " " . $data["anioFin"];
            $now = date("d/m/Y");

            if ($form->get("pdf")->isClicked()) {

                $snappy = $this->get("knp_snappy.pdf");
                $html = $this->renderView("RepEstrategicos/Reportes/reporte_rentabilidad.html.twig",
                    array("data"=>$res, "tipoPeriodo" => $tipoPeriodo, "today" => $now,
                        "periodoInicio"=> $periodoInicio, "periodoFin" => $periodoFin));

                $filename = "reportePDF";

                return new Response(
                    $snappy->getOutputFromHtml($html),
                    200,
                    array(
                        'Content-Type'          => 'application/pdf',
                        'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
                    )
                );
            }
            else if ($form->get("send")->isClicked()) {
                return $this->render('RepEstrategicos/CapturaDatos/PreviewTables/preview_rentabilidad.html.twig', array(
                    'form' => $form->createView(), "pageHeader" => "Reporte de Indicador de Rentabilidad",
                    "data" => $res, "tipoPeriodo" => $tipoPeriodo
                ));
            }





        }

        return $this->render('RepEstrategicos/CapturaDatos/rep_res_eficiencia_com_glo.html.twig', array(
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
        $stmnt = $conn->prepare("SELECT id_sector, nombre_sector FROM dbtransaccional.sectores");
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

        return $this->render('RepEstrategicos/CapturaDatos/rep_cont_servicio.html.twig', array(
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
        $stmnt = $conn->prepare("SELECT id_sector, nombre_sector FROM dbtransaccional.sectores");
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

        return $this->render('RepEstrategicos/CapturaDatos/rep_cont_servicio.html.twig', array(
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
        $stmnt = $conn->prepare("SELECT id_tipo_reclamo, descripcion FROM dbtransaccional.tipo_reclamos");
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

        return $this->render('RepEstrategicos/CapturaDatos/rep_resp_reclamos.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte de Indicador de Tiempo de Respuesta a Reclamos"
        ));
    }

}
