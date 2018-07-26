<?php
namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminUsersController extends Controller
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
  public function AdminUsersAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
      throw new AccessDeniedException('Access denied for clients');
    }
    $WebInfos = $this->RetrieveWebInfos();
    $users  = $this->RetrieveUsers();
    return $this->render('@WebBundle/Resources/views/Default/adminUsers.html.twig', array(
        'WebInfos'      => $WebInfos,
        'users'         => $users,
    ));
  }
}
