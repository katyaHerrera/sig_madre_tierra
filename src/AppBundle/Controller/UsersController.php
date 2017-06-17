<?php
/**
 * Created by PhpStorm.
 * User: cgcomputadoras
 * Date: 7/6/2017
 * Time: 2:03 PM
 */

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UsersController extends Controller
{
    //muestra la lista de usuarios
    /**
     * @Route("/users", name="show_users")
     */
    public function showUsersAction(){

        $em=$this->getDoctrine()->getManager();
        $users=$em->getRepository('AppBundle:User')->findAll();

        if (!$users) {
            throw $this->createNotFoundException('Usuarios no encontrados');
        }

        $deleteFormAjax=$this->createCustomForm(':USER_ID',"DELETE","user_detele");
        $updateFormAjax=$this->createCustomForm(':USER_ID','POST','user_update');


        return $this->render('users/showusers.html.twig',array(
            'users'=>$users,
            'delete_form_ajax'=>$deleteFormAjax->createView(),
            'update_form_ajax'=>$updateFormAjax->createView()

        ));

    }

    /**
     * @Route("user/update/{idUser}", name="user_update")
     *
     */

    public function updateuserAction(Request $request,$idUser){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(['id'=>$idUser]);

        if(!$user){
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $form=$this->createCustomForm($idUser,'POST','user_update');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($request->isXmlHttpRequest()){
                if($user->isEnabled()==1){
                    $update=0;//se desabilito
                    $user->setEnabled(0);
                    $message='El usuario se desactivo con exito';
                }else{
                    $update=1;//se habilito
                    $user->setEnabled(1);
                    $message='El usuario se activo con exito';
                }

                $em->persist($user);
                $em->flush();

                return new Response(
                    json_encode(array('update'=>$update,'message'=>$message)),
                    200,
                    array('Content-Type'=>'application/json')
                );

            }
        }

    }

    /**
     * @Route("user/delete/{idUser}", name="user_detele")
     *
     */

    public function deleteuser(Request $request, $idUser){

        $em=$this->getDoctrine()->getManager();
        $user= $em->getRepository('AppBundle:User')->findOneBy(['id'=>$idUser]);
        if(!$user){
            throw $this->createNotFoundException('Usuario no encontrador');
        }

        $form=$this->createCustomForm($user->getId(),'DELETE','user_detele');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if($request->isXmlHttpRequest()){
                $res=$this->deleteUserR($em, $user);

                return new Response(
                    json_encode(array('removed'=>$res['removed'], 'message'=>$res['message'])),
                    200,
                    array('Content-Type'=>'application/json')

                );
            }
        }
    }

    private function deleteUserR($em,$user){

        $removed=0;
        $em->remove($user);
        $em->flush();
        $message="El usuario ha sido eliminado";
        $removed=1;
        $alert='mensaje';

        return array('removed'=>$removed, 'message'=> $message, 'alert'=>$alert);
    }

    /**
     * @Route("/users/{idUser}", name="show_detail_user")
     */

    public function detailuserAction($idUser){

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository('AppBundle:User')->findOneBy(['id'=>$idUser]);

        if(!$user){
            throw $this->createNotFoundException('Usuario no encontrador');
        }

        return $this->render('users/user.html.twig',array(
            'users'=>$user
        ));
    }

    private function createCustomForm($idUser,$method,$route){
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route,array('idUser'=>$idUser)))
            ->setMethod($method)
            ->getForm();

    }


}