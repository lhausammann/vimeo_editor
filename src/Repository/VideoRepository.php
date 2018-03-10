<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Video::class);
    }
    
    public function getIds() 
    {
        $em = $this->getEntityManager();
        $result = $em->createQuery("SELECT v.id FROM App\\Entity\\Video v")->getScalarResult();
        return array_column($result, "id");
    }
    
    public function getAll() 
    {
        return $this->createQueryBuilder('v')->getQuery()->getResult();
    }
    
    /*
     * Prefix the id and fetch the first.
     * Make sure to return first result only.
     * 
     */
    public function findById($id) 
    {
        $id = '/videos/' . $id;
        return parent::findById($id)[0];
    }
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('v')
            ->where('v.something = :value')->setParameter('value', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
     * 
     * 
    */
    
    public function persist(Video $video) 
    {
        $this->getEntityManager()->merge($video);
        $this->getEntityManager()->flush();
    }
}
