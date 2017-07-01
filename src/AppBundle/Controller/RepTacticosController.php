<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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



        $stmnt = $conn->prepare("SELECT id_tarifa, CONCAT('$',cobro, '  (', consumo_min, 'm3 -', consumo_max, 'm3)') rango FROM 
transaccional.tarifas where tipo_conexion=1");
        $stmnt->execute();

        $result = $stmnt->fetchAll();

        $tarifas = array_combine(array_column($result, "rango"), array_column($result, "id_tarifa"));









        $stmnt2 = $conn->prepare("SELECT id_tarifa, CONCAT('$',cobro, '  (', consumo_min, 'm3 -', consumo_max, 'm3)') rango FROM 
transaccional.tarifas where tipo_conexion=2");
        $stmnt2->execute();

        $result2 = $stmnt2->fetchAll();

        $tarifas2 = array_combine(array_column($result2, "rango"), array_column($result2, "id_tarifa"));










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
            ->add('tarifa', ChoiceType::class, array(
                "choices" => array( 'Residenciales' =>$tarifas , 'Comerciales' =>$tarifas2),
                "constraints" => new NotBlank(array("message" => "Por favor seleccione un rango de tarifa"))

            ))

            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->add('pdf', SubmitType::class, array("label" => "Crear PDF"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();

            $conn = $this->getDoctrine()->getManager()->getConnection();
            $stmntContServicio = $conn->prepare("SELECT tp.nombre_tipo_conexion,(sum(rm.total_consumo)/:periodo) consumo, CONCAT('$',ta.cobro, '  (', ta.consumo_min, 'm3 -', ta.consumo_max, 'm3)') rango, ta.cobro, ta.tipo_conexion ,rm.anio, (FLOOR((rm.mes -1 ) / :periodo) + 1) periodo
                                             
                                              FROM symfony.res_micromediciones rm INNER JOIN transaccional.tarifas ta ON rm.id_tarifa=ta.id_tarifa
                                              INNER JOIN transaccional.tipo_conexiones tp ON ta.tipo_conexion=tp.id_tipo_conexion
                                              WHERE (rm.anio * 12 + rm.mes) >= (:anioInicio * 12 + :mesInicio) AND 
                                              (rm.anio * 12 + rm.mes) <= (:anioFin * 12 + :mesFin) AND ta.id_tarifa=:tarifa
                                              GROUP BY rm.anio, FLOOR((rm.mes - 1) / :periodo)
                                              ORDER BY rm.anio, periodo");



            $stmntContServicio->bindValue("periodo", $data["periodo"]);
            $stmntContServicio->bindValue("anioInicio", $data["anioInicio"]);
            $stmntContServicio->bindValue("mesInicio", $data["mesInicio"]);
            $stmntContServicio->bindValue("anioFin", $data["anioFin"]);
            $stmntContServicio->bindValue("mesFin", $data["mesFin"]);
            $stmntContServicio->bindValue("tarifa", $data["tarifa"]);


            $stmntContServicio->execute();

            $resultContServicio = $stmntContServicio->fetchAll();


            $res = array();

            for ($i = 0; $i < count( $resultContServicio); $i++)
            {

                $rango= $resultContServicio[$i]["rango"];
                $tipoCon= $resultContServicio[$i]["nombre_tipo_conexion"];

                $res[] = array("consumo" => $resultContServicio[$i]["consumo"],
                    "cobro" => $resultContServicio[$i]["cobro"],
                    "periodo" =>$resultContServicio[$i]["periodo"],
                    "anio" => $resultContServicio[$i]["anio"]);
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
                $html = $this->renderView("RepTacticos/Reportes/reporte_consumo_tarifa.html.twig",
                    array("data"=>$res, "tipoPeriodo" => $tipoPeriodo, "today" => $now,
                        "periodoInicio"=> $periodoInicio, "periodoFin" => $periodoFin, "rango" => $rango, "con" => $tipoCon));

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
                return $this->render('RepTacticos/CapturaDatos/PreviewTables/preview_consumo_tarifa.html.twig', array(
                    'form' => $form->createView(), "pageHeader" => "Reporte de continuidad de servicio",
                    "data" => $res, "tipoPeriodo" => $tipoPeriodo, "rango" => $rango, "con" => $tipoCon
                ));
            }




        }

        return $this->render('RepTacticos/CapturaDatos/rep_semi_res_consumo_agua.html.twig', array(
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
            ->add('send', SubmitType::class, array("label"=>"Enviar"))
            ->add('pdf', SubmitType::class, array("label" => "Crear PDF"))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with the name of the inputs as keys to its values
            $data = $form->getData();
            $diff = ($data["anioFin"] * 12 + $data["mesFin"])
                - ($data["anioInicio"] * 12 + $data["mesInicio"]);

            if ($diff >= 0) {
                $conn = $this->getDoctrine()->getManager()->getConnection();
                $stmntConsumido = $conn->prepare("SELECT SUM(micro.total_consumo) consumo, micro.anio, 
                                                  (FLOOR((micro.mes -1 ) / :periodo) + 1) periodo 
                                                  FROM res_micromediciones micro
                                                  WHERE (micro.anio * 12 + micro.mes) >= (:anioInicio *12 + :mesInicio) AND 
                                                  (micro.anio * 12 + micro.mes) <= (:anioFin * 12 + :mesFin)
                                                  GROUP BY micro.anio, FLOOR((micro.mes - 1) / :periodo)
                                                  ORDER BY micro.anio, periodo;");

                $stmntExtraido = $conn->prepare("SELECT macro.anio, (FLOOR((macro.mes -1 ) / :periodo) + 1) periodo, 
                                            SUM(macro.total_extraido) extraido
                                            FROM res_macromedicion macro
                                            WHERE (macro.anio * 12 + macro.mes) >= (:anioInicio * 12 + :mesInicio) AND 
                                            (macro.anio * 12 + macro.mes) <= (:anioFin * 12 + :mesFin)
                                            GROUP BY macro.anio, FLOOR((macro.mes - 1) / :periodo)
                                            ORDER BY macro.anio, periodo;");

                $stmntProblemas = $conn->prepare("SELECT SUM(rep.id_res_reporte) cantidad, rep.anio, 
                                                  (FLOOR((rep.mes -1 ) / :periodo) + 1) periodo, rep.tipo_reporte
                                                  FROM res_reportes_campo rep
                                                  INNER JOIN dbtransaccional.tipo_reporte tipo ON 
                                                  tipo.id_tipo_reporte = rep.tipo_reporte
                                                  WHERE (rep.anio * 12 + rep.mes) >= (:anioInicio * 12 + :mesInicio) 
                                                  AND (rep.anio * 12 + rep.mes) <= (:anioFin * 12 + :mesFin)
                                                  GROUP BY rep.anio, FLOOR((rep.mes - 1) / :periodo), rep.tipo_reporte
                                                  ORDER BY rep.anio, periodo, rep.tipo_reporte;");

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

                $stmntProblemas->bindValue("periodo", $data["periodo"]);
                $stmntProblemas->bindValue("anioInicio", $data["anioInicio"]);
                $stmntProblemas->bindValue("mesInicio", $data["mesInicio"]);
                $stmntProblemas->bindValue("anioFin", $data["anioFin"]);
                $stmntProblemas->bindValue("mesFin", $data["mesFin"]);

                $stmntProblemas->execute();
                $stmntExtraido->execute();
                $stmntConsumido->execute();

                $resultConsumido = $stmntConsumido->fetchAll();
                $resultExtraido = $stmntExtraido->fetchAll();
                $resultProblemas = $stmntProblemas->fetchAll();

                $res = array();

                for ($i = 0; $i < count($resultConsumido); $i++) {
                    $fisica = $resultExtraido[$i]["extraido"] / $resultConsumido[$i]["consumo"] ;


                    $res[] = array("producido" => $resultConsumido[$i]["consumo"],
                        "facturado" => $resultExtraido[$i]["extraido"],
                        "fisica" => $fisica,
                        "roturas" => $resultProblemas[$i]["cantidad"],
                        "rebalses" => $resultProblemas[$i  + 1]["cantidad"],
                        "ilegales" => $resultProblemas[$i + 1]["cantidad"],
                        "periodo" => $resultExtraido[$i]["periodo"],
                        "anio" => $resultExtraido[$i]["anio"]);
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
                    $html = $this->renderView("RepTacticos/Reportes/reporte_eficiencia_fisica.html.twig",
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
                    return $this->render('RepTacticos/CapturaDatos/PreviewTable/preview_eficiencia_fisica.html.twig', array(
                        'form' => $form->createView(), "pageHeader" => "Reporte de Indicadores de Eficiencia Global y Comercial",
                        "data" => $res, "tipoPeriodo" => $tipoPeriodo
                    ));
                }

            }
            else{
                $form->addError(new FormError("La fecha de inicio no puede ser mayor a la fecha de Fin"));
                return $this->render('RepTacticos/CapturaDatos/rep_semi_res_eficiencia_fisica.html.twig', array(
                    'form' => $form->createView(), "pageHeader" => "Reporte de Indicadores de Eficiencia Global y Comercial"
                ));
            }
        }

        return $this->render('RepTacticos/CapturaDatos/rep_semi_res_eficiencia_fisica.html.twig', array(
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

        return $this->render('RepTacticos/CapturaDatos/rep_semi_res_eficiencia_fisica.html.twig', array(
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

        return $this->render('RepTacticos/CapturaDatos/rep_semi_res_eficiencia_fisica.html.twig', array(
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

        return $this->render('RepTacticos/CapturaDatos/rep_semi_res_acom_activas.html.twig', array(
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

        return $this->render('RepTacticos/CapturaDatos/rep_semi_res_acom_activas.html.twig', array(
            'form' => $form->createView(), "pageHeader" => "Reporte semi-resumen de clientes con mayor consumo"
        ));
    }
}
