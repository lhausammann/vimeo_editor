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
    
    public function deleteAll() 
    {
        
        $em = $this->getEntityManager();
        $cmd = $em->getClassMetadata('App\\Entity\\UnimportedVideo');
        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {
            # $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $connection->query('DELETE FROM '.$cmd->getTableName());
            // Beware of ALTER TABLE here--it's another DDL statement and will cause
            // an implicit commit.
            # $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }
    }
    
    public function getIds() 
    {
        $em = $this->getEntityManager();
        $result = $em->createQuery("SELECT v.id FROM App\\Entity\\UnimportedVideo v")->getScalarResult();
        return array_column($result, "id");
    }
}
