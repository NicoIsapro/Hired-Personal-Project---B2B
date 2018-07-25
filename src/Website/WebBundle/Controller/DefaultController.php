<?php

namespace Website\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller
{
    public function FindCatId($slug)
    {
      $repository = $this->getDoctrine()
        ->getRepository('WebBundle:Categories')
        ->findOneByname($slug)
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
    public function RetrieveCategories()
    {
      $repository = $this->getDoctrine()
        ->getRepository('WebBundle:Categories')
        ->findAll();
      ;
      return $repository;
    }
    public function RetrieveProducts($slug)
    {
      $catid = $this->FindCatId($slug);
      $repository = $this->getDoctrine()
        ->getRepository('WebBundle:Products')
        ->findBycategid($catid);
      ;
      return $repository;
    }
    public function IndexAction($slug)
    {
    $WebInfos = $this->RetrieveWebInfos();
    $Categories = $this->RetrieveCategories();
    $products = $this->RetrieveProducts($slug);
    return $this->render('/home/nicoisapro/my_site_28/src/Website/WebBundle/Resources/views/Default/shop.html.twig',
   array('WebInfos' => $WebInfos, 'categories' => $Categories, 'products' => $products, 'category' => $slug)
  );
 }
}
