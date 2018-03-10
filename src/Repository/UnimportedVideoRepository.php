<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository;
use App\Entity\UnimportedVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Description of UnimportedVideoRepository
 *
 * @author luzius
 */
class UnimportedVideoRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UnimportedVideo::class);
    }
    
    public function persist(\App\Entity\UnimportedVideo $video) 
    {
        //var_dump($video);
        $this->getEntityManager()->merge($video);
        $this->getEntityManager()->flush();
    }
    
    public function getIds() 
    {
        $em = $this->getEntityManager();
        $result = $em->createQuery("SELECT v.id FROM App\\Entity\\UnimportedVideo v")->getScalarResult();
        return array_column($result, "id");
    }
}
