<?php

namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogoutController extends Controller
{
  public function LogoutAction()
  {
    $request = $this->getRequest();
    $session = $request->getSession();
    $session->remove();
    return $this->redirectToRoute('root');
  }
}
