<?php

namespace Website\OrderBundle\Repository;

use Doctrine\ORM\Mapping as ORM;

/**
 * User repository.
 */
class OrderRepository extends ORM
{
    public function findOrdersByName($name)
    {
        return $this->getQueryBuilder()
            ->select('products.name as 'Name',
                      products.description as 'Email',
                      users.username as 'Buyer',
                      orders.status as 'Status',
                      products.price as 'price',
                      categories.name as 'Category',
                      orders.date as 'Date'')
            ->from('orders')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('products', 'orders.prodid', '=', 'products.id')
            ->join('categories', 'products.categid', '=', 'categories.id')
            ->andWhere('users.name = :name')
            ->setParameter('name', $name)
            ->groupBy('orders.date')
            ->getQuery()
            ->getResult();
    }
}
