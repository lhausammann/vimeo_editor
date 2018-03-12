<?php
namespace App\Controller;

use App\Repository\VideoRepository;
use App\Entity\Video;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function importAction(Request $request) 
    {
            return $this->render('front/home.html.twig', array('t', time()));
        }
}
