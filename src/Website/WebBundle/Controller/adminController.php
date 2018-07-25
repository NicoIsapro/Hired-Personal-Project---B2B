<?php
namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class adminController extends Controller
{
  public function CountTopCompany()
  {
    $sql = "
    SELECT company, price, SUM(price) AS 'Total' FROM orders JOIN products ON orders.prodid = products.id GROUP BY company ORDER BY `price` DESC
    ";
    $em = $this->getDoctrine()->getManager();
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function CountOrdersWeek()
  {
    $sql = "
    SELECT COUNT(*) as num FROM orders WHERE date > NOW() - INTERVAL 1 WEEK
    ";
    $em = $this->getDoctrine()->getManager();
    $stmt = $em->getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function RetrieveOrders()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:Orders')
      ->findAll();
    ;
    return $repository;
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
  public function RetrieveWebInfos()
  {
    $repository = $this->getDoctrine()
      ->getRepository('WebBundle:WebConfig')
    ;
    return $repository->findAll();
  }
  public function adminAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
      throw new AccessDeniedException('Access denied for clients');
    }
    $products = $this->RetrieveProducts();
    $WebInfos = $this->RetrieveWebInfos();
    $orders = $this->RetrieveOrders();
    $categories = $this->RetrieveCategories();
    $NumOrdersWeek = $this->CountOrdersWeek();
    $TopCompanies  = $this->CountTopCompany();
    $users  = $this->RetrieveUsers();
    return $this->render('/home/nicoisapro/my_site_28/src/Website/WebBundle/Resources/views/Default/admin.html.twig', array(
        'WebInfos'      => $WebInfos,
        'products'      => $products,
        'orders'        => $orders,
        'countOrderWeek' => $NumOrdersWeek,
        'categories'    => $categories,
        'topcompanies'  => $TopCompanies,
        'users'         => $users,
    ));
  }
}
