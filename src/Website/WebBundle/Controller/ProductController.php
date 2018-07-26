<?php

namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends Controller
{
    public function RetrieveWebInfos()
    {
      $repository = $this->getDoctrine()
        ->getRepository('WebBundle:WebConfig')
      ;
      return $repository->findAll();
    }
    public function RetrieveCategories()
    {
      $repository = $this->getDoctrine()
        ->getRepository('WebBundle:Categories')
        ->findAll();
      ;
      return $repository;
    }
    public function RetrieveProduct($prodid)
    {
      $repository = $this->getDoctrine()
        ->getRepository('WebBundle:Products')
        ->findByid($prodid);
      ;
      return $repository;
    }
    public function ProductAction($categ, $prodid)
    {
    $WebInfos = $this->RetrieveWebInfos();
    $Categories = $this->RetrieveCategories();
    $product = $this->RetrieveProduct($prodid);
    return $this->render('@WebBundle/Resources/views/Default/product.html.twig', array(
      'WebInfos' => $WebInfos,
      'categories' => $Categories,
      'category' => $categ,
      'product' => $product)
  );
 }
}
