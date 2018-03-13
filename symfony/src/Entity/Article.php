<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Folder")
     * @ORM\JoinColumn(name="folder_id", referencedColumnName="id")
     */
    private $folder;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getFolder()
    {
        return $this->folder;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }
}
