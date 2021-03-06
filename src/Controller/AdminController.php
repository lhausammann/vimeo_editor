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
 * @Route("/admin")
 * @author luzius
 */
class AdminController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {
    //put your code here
    /**
     * @Route("/import", name="import")
     */
    public function importAction(Request $request) 
    {
        $client = $this->container->get('App\\Services\\VimeoVClient\\Client');
        $repo = $this->get('App\\Repository\\VideoRepository');
        $unimportedRepo = $this->get('App\\Repository\\UnimportedVideoRepository');
        $videos = $client->getVideos();
        // split it into a blacklist and a storelist
        $blackList = array_flip(array_merge($repo->getIds(), $unimportedRepo->getIds()));
        $toSave = array();
        if ($request->isMethod('post')) {
            $candidates = $request->request->get('i');
            foreach($candidates as $candidate) {
                if (isset($candidate['checked'])) {
                    // add it to the import list
                    $toSave[] = $video = new Video($candidate);
                    $repo->persist($video);
                } else {
                    $unimportedVideo = new \App\Entity\UnimportedVideo($candidate);
                    $unimportedRepo->persist($unimportedVideo);
                }
            }
            
            return $this->redirectToRoute('list', array('t', time()));
        }
        
        $videosToImport = array();
        foreach ($videos as $videoData) 
        {
            if (isset($blackList[$videoData['id']])) {
                continue;
            }
            
            $importId = explode('/',$videoData['id']);
            $importId = array_pop($importId);
            $videoData['importId'] = $importId;
            //$video = new Video($videoData);
            //$repo->persist($video);
            $videosToImport[] = $videoData;
        }
        
        return $this->render('admin/import.html.twig', array('videos' => $videosToImport, 'isActive' => 'import'));
    }
    
    /**
     * @Route("/list", name="list")
     */
    public function listAction() 
    {
        $repo = $this->get('App\\Repository\\VideoRepository');
        return $this->render('admin/list.html.twig', array('videos' => $repo->findAll(), 'isActive' => 'edit'));
    }
    
    /**
     * @Route("/delete_all", name="delete_all")
     */
    public function deleteAllAction() 
    {
        
        $repo = $this->get('App\\Repository\\UnimportedVideoRepository');
        $repo->deleteAll();
        $repo = $this->get('App\\Repository\\VideoRepository');
        $repo->deleteAll();
        return $this->redirectToRoute('import');
    }
    
    /**
     * @Route("/toggle_user_active/{id}", name="toggle_user")
     */
    public function toggleUserActive($id) 
    {
        $repo = $this->get('App\\Repository\\UserRepository');
        $repo->toggleActive($id);
        
        return $this->redirectToRoute('admin_user');
    }
    
    /**
     * @Route("/user", name="admin_user")
     */
    public function userAction() 
    {
        $repo = $this->get('App\\Repository\\UserRepository');
        return $this->render('admin/users.html.twig', array('users' => $repo->findAll(), 'isActive' => 'user'));
    }
   
    /**
     * @Route("/", name="admin_home")
     */
    public function adminHomeAction() 
    {
        return $this->redirectToRoute('list');
    }
    
    /**
     * @Route("/edit/{id}",name="edit")
     */
    public function editAction(int $id) 
    {
        $repo = $this->get('App\\Repository\\VideoRepository');
        return $this->render('admin/edit.html.twig', array('video' => $repo->findById($id), 'isActive' => 'edit'));
    }
    /**
     * 
     * @Route("/save/", name="save")
     */
    public function saveAction(Request $request) {
        $videoData = $request->request->get('video');
        $repo = $this->get('App\\Repository\\VideoRepository');
        $id = $videoData['id'];
        $video = $repo->findById($id);
        // check which fields to update
        $name = $video->getName();
        $description = $video->getDescription();
        
        if ($video->getDescription() != $videoData['description'] 
            || $video->getName() != $videoData['name']) {
            $video->setName($videoData['name']);
            $video->setDescription($videoData['description']);
            $repo->persist($video);
        }
        
        return $this->redirectToRoute('list', ['edited' => $id]);
    }
}
