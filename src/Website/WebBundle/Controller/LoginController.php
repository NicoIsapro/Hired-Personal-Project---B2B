<?php

namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LoginController extends Controller
{
  public function RetrieveWebInfos()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:WebConfig')
    ;
    return $repository->findAll();
  }
  public function loginAction(Request $request)
  {
    $authenticationUtils = $this->get('security.authentication_utils');
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();
    $WebInfos = $this->RetrieveWebInfos();
    return $this->render('/home/nicoisapro/my_site_28/src/Website/WebBundle/Resources/views/Default/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
        'WebInfos'      => $WebInfos,
    ));
  }
}