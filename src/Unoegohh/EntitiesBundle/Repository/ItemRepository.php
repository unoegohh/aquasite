<?php

namespace Unoegohh\EntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Unoegohh\EntitiesBundle\Entity\FoodCategory;
use Unoegohh\EntitiesBundle\Entity\ItemCategory;
use Unoegohh\UserBundle\Entity\User;

class ItemRepository extends EntityRepository
{
    public function getProductsByCategory(ItemCategory $category = null, $page,$limit)
    {
        $qb = $this->createQueryBuilder('u');
        if($category){

            $ids = array();
            $ids[] = $category->getId();
            foreach($category->getChild() as $child){
                $ids[] = $child->getId();
            }
            $qb
                ->where($qb->expr()->in('u.category_id', $ids));
        }
        $qb
        ->setFirstResult(($page-1)*$limit)
        ->setMaxResults($limit);

        $result =array();
        $result['items'] = $qb->getQuery()->getResult();
        $qb = $this->createQueryBuilder('u');
        $qb->select('count(u.id)');
        
        if($category){

            $ids = array();
            $ids[] = $category->getId();
            foreach($category->getChild() as $child){
                $ids[] = $child->getId();
            }
            $qb
                ->where($qb->expr()->in('u.category_id', $ids));
        }
        $result['total'] = ceil($qb->getQuery()->getSingleScalarResult()/$limit);

        return $result;
    }

    public function getNamedProducts($name)
    {

        $qb = $this->createQueryBuilder('u');
        $qb
            ->where($qb->expr()->like('u.name', $qb->expr()->literal('%' . $name . '%')));

        $result = $qb->getQuery()->getResult();

        return $result;
    }

}