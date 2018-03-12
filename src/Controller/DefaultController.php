<?php
namespace App\Controller;

use App\Repository\VideoRepository;
use App\Entity\Video;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultController
 * @author luzius
 */
class DefaultController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {
    /**
     * @Route("/")
     */
    public function indexAction(Request $request) 
    {
        
        return $this->render('front/home.html.twig', array('t', time()));
    }
    
    /**
     * @Route("/videos")
     * @IsGranted("ROLE_USER")
     */
    public function videoAction(Request $request) 
    {
        
        $repo = $this->get('App\\Repository\\VideoRepository');
        return $this->render('front/videos.html.twig', array(
            'videos' => $repo->findAll(),
            'title' => 'Neue Videos',
            'lead' => 'Hier folgen dann Kategorien usw.'));
    }
}
