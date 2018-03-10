<?php
namespace App\Services\Vimeo;
use Vimeo;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author luzius
 */
class Client {
    private $config;
    private $client;
    private $cache;
    
    const MAX_CALLS_PER_REQUEST = 10;
    
    private $callCounter = 0;
    
    public function __construct(Config $config, SessionInterface $cache) {
        $this->config = $config;
        $this->client = new Vimeo($this->config->appId, $this->config->secret);
        $this->cache = $cache;
        //put your code here
    }  
    
    public function getVideos() {
        if (self::MAX_CALLS_PER_REQUEST == $this->callCounter) {
            throw new \Exception("Max limit of requests reached.");
        }
        $this->callCounter++;
        $lib = $this->client;
        $lib->setToken($this->config->accessToken);
        $results = $lib->request('/me/videos');
        $videos = array();
        if (isset($results['body']['error'])) {
            //var_dump($results);
            throw new VimeoClientException($results['body']['error']);
        }
                
        // todo: fetch all videos...
        foreach ($results['body']['data'] as $asset) {
        
            $video = array();
            $video['id'] =  $asset['uri'];
            $video['name'] = $asset['name'];
            $video['duration'] = $asset['duration'];
            $video['description'] = $asset['description'];
            $video['img'] = $asset['pictures']['sizes'][2]['link'] ?? '';
            $video['embed'] = $asset['embed']['html'];
            
            $videos[] = $video;
        }
            
            return $videos;
    }
}
    
