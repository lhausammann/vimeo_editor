<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
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
     * @ORM\Column(type="string", length=100)
     */
    protected $img;
    
    /**
     * @ORM\Column(type="string", length=500)
     */
    protected $embed;
    
    /**
     * @ORM\Column(type="text")
     * 
     */
    private $description = '';
    
    public function getTitle() 
    {
        return $this->title;
    }
    
    public function getVimeoUrl() 
    {
        
    }
    
    public function getId() {
        // for our frontend we strip the "video/" part from the id.
        $id = explode('/', $this->id);
        return $id[2];
    }
    
    
    public function getName() 
    {
        return $this->name;
    }
    
    public function setName($name) 
    {
        $this->name = $name;
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
    

    
    public function getEmbed() {
        return $this->embed;
    }
}
