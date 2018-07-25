<?php

namespace Website\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Website\WebBundle\Entity\Users;
use Website\WebBundle\Form\UserRegistrationForm;

class SignupController extends Controller
{
  public function RetrieveWebInfos()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:WebConfig')
    ;
    return $repository->findAll();
  }
  public function signupAction(Request $request)
  {
    $user = new Users();
    $form = $this->createForm(UserRegistrationForm::class, $user);

    $form->handleRequest($request);
    $form->getErrors();
    if ($form->isSubmitted() && $form->isValid()) {
      $password = $this->get('security.password_encoder')
        ->encodePassword($user, $user->getPassword());
      $user->setPassword($password);
      $user->setRoles("ROLE_CLIENT");
      $user->setDate(new \DateTime('now'));
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('login');
    }

    $WebInfos = $this->RetrieveWebInfos();
    return $this->render('/home/nicoisapro/my_site_28/src/Website/WebBundle/Resources/views/Default/signup.html.twig', array(
        'WebInfos'      => $WebInfos,
        'form' => $form->createView(),
    ));
  }
}
