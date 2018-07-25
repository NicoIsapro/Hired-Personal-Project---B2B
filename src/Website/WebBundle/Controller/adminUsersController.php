<?php
namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class adminUsersController extends Controller
{
  public function RetrieveUsers()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:Users')
      ->findAll();
    ;
    return $repository;
  }
  public function RetrieveWebInfos()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:WebConfig')
    ;
    return $repository->findAll();
  }
  public function adminUsersAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
      throw new AccessDeniedException('Access denied for clients');
    }
    $WebInfos = $this->RetrieveWebInfos();
    $users  = $this->RetrieveUsers();
    return $this->render('/home/nicoisapro/my_site_28/src/Website/WebBundle/Resources/views/Default/adminUsers.html.twig', array(
        'WebInfos'      => $WebInfos,
        'users'         => $users,
    ));
  }
}
