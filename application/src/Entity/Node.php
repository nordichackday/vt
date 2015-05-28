<?php

namespace VT\Entity;

class Node
{

    private $mediaId;
    private $intro;
    private $body;
    private $timestamp;

    public function __construct($mediaId, $intro, $timestamp, $body = [])
    {
        $this->setMediaId($mediaId);
        $this->setIntro($intro);
        $this->setBody($body);
        $this->setTimestamp($timestamp);
    }

    /**
     * @return mixed
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * @param mixed $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
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
        $this->body = $body;
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
