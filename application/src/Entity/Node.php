<?php

namespace VT\Entity;

class Node
{

    private $storyGroup;
    private $intro;
    private $body;
    private $timestamp;

    public function __construct($storyGroup, $intro, $timestamp, $body = [])
    {
        $this->setStoryGroup($storyGroup);
        $this->setIntro($intro);
        $this->setBody($body);
        $this->setTimestamp($timestamp);
    }

    /**
     * @return mixed
     */
    public function getStoryGroup()
    {
        return $this->storyGroup;
    }

    /**
     * @param mixed $storyGroup
     */
    public function setStoryGroup($storyGroup)
    {
        $this->storyGroup = $storyGroup;
    }

    /**
     * @return mixed
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * @param mixed $intro
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $tmpArr = [];
        if(is_array($body)) {
            foreach ($body as $section) {
                $tmpArr[] = ['text' => $section];
            }
        }
        $this->body['sections'] = $tmpArr;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        if(!isset($timestamp)) {
            $timestamp = time();
        }

        $this->timestamp = $timestamp;
    }
}
