<?php
namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ClientsController extends Controller
{
  public function RetrieveWebInfos()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:WebConfig')
    ;
    return $repository->findAll();
  }
  public function RetrieveOrders($username)
  {
    $sql = "
    SELECT * FROM orders JOIN users ON orders.userid = users.id JOIN products ON orders.prodid = products.id JOIN categories ON products.categid = categories.id WHERE users.name ='$username'
    ";
    $em = $this->getDoctrine()->getManager();
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function CountOrdersWeek($username)
  {
    $sql = "
    SELECT COUNT(*) as total FROM orders JOIN users ON orders.userid = users.id WHERE users.name ='$username' AND date > NOW() - INTERVAL 1 WEEK
    ";
    $em = $this->getDoctrine()->getManager();
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function RetrieveCategories()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:Categories')
      ->findAll();
    ;
    return $repository;
  }
  public function RetrieveUsers()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:Users')
      ->findAll();
    ;
    return $repository;
  }
  public function RetrieveProducts()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:Products')
      ->findAll();
    ;
    return $repository;
  }
  public function clientsAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
      throw new AccessDeniedException('Access restricted for clients only');
    }
    $username = $this->get('security.token_storage')->getToken()->getUser();
    $username->getUsername();
    $WebInfos = $this->RetrieveWebInfos();
    $products = $this->RetrieveProducts();
    $categories = $this->RetrieveCategories();
    $ordersClient = $this->RetrieveOrders($username);
    $OrdersWeek   = $this->CountOrdersWeek($username);
    $users = $this->RetrieveUsers();
    return $this->render('/home/nicoisapro/my_site_28/src/Website/WebBundle/Resources/views/Default/client.html.twig', array(
        'products'      => $products,
        'WebInfos'      => $WebInfos,
        'categories'    => $categories,
        'orders'        => $ordersClient,
        'ordersWeek'    => $OrdersWeek,
        'users'         => $users,
    ));
  }
}
