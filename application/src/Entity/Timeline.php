<?php

namespace VT\Entity;

class Timeline
{
    private $title;
    private $intro;
    private $nodes;

    /**
     * @return mixed
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @return mixed
     */
    public function addNode($node)
    {
        return $this->nodes[] = $node;
    }

    /**
     * @param mixed $nodes
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return utf8_decode($this->title);
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = utf8_encode($title);
    }

    /**
     * @return mixed
     */
    public function getIntro()
    {
        return utf8_decode($this->intro);
    }

    /**
     * @param mixed $intro
     */
    public function setIntro($intro)
    {
        $this->intro = utf8_encode($intro);
    }
}
