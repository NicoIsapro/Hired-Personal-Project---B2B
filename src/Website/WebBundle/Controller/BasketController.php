<?php

namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasketController extends Controller
{
  public function RetrieveWebInfos()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:WebConfig')
    ;
    return $repository->findAll();
  }
  public function BasketAction()
  {
    $WebInfos = $this->RetrieveWebInfos();

    return $this->render('@WebBundle/Resources/views/Default/basket.html.twig', array(
        'WebInfos'      => $WebInfos,
    ));
  }
}
