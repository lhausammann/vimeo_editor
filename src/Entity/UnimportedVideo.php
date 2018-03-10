<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnimportedVideoRepository")
 */
class UnimportedVideo
{
    public function __construct(array $videoData) {
        $this->id = $videoData['id'];
        $this->name = $videoData['name'];
        $this->description = $videoData['description'] ?? '';
        $this->embed = $videoData['embed'];
        $this->img = $videoData['img'] ?? '';
    }
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    // add your own fields
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text")
     * 
     */
    private $description = '';
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $img;
    
    /**
     * @ORM\Column(type="string", length=500)
     */
    protected $embed;
    
    public function getTitle() 
    {
        return $this->title;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function setImg($image) {
        $this->img = $image;
    }
    
    public function getImg() 
    {
        return $this->img;
    }
    
    public function setDescription($description) 
    {
        $this->description = $description;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setEmbed($embed) {
        $this->embed = $embed;
    }
    
    public function getEmbed() {
        return $this->embed;
    }
}
