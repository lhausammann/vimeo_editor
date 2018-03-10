<?php
 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Import;

use App\Repository\VideoRepository;
use App\Services\Vimeo\Client;
/**
 * Description of VimeoImporter
 *
 * @author luzius
 */
class VimeoImporter {
    private $client;
    private $repository;
            
    public function __construct(Client $client, VideoRepository $repository) {
        $this->repository = $repository;
        $this->client = $client;
    }
}
