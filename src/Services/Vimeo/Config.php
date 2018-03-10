<?php
namespace App\Services\Vimeo;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
 *
 * @author luzius
 */



class Config 
{
    public $vimeoId;
    public $vimeoSecret;
    public $vimeoAccessToken;

    public function __construct($vimeoAppId, $vimeoAppSecret, $vimeoAccessToken) {
        $this->appId = $vimeoAppId;
        $this->secret = $vimeoAppSecret;
        $this->accessToken = $vimeoAccessToken;
    }
}
