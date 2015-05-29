<?php

namespace VT\Entity;

class Node
{

    private $mediaId;
    private $title;
    private $body;
    private $label;
    /** @var $widget Widget */
    private $widget;
    private $order;

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
        $this->mediaId = (integer) $mediaId;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return utf8_decode($this->body);
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = utf8_encode($body);
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return utf8_decode($this->label);
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return Widget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param Widget $widget
     */
    public function setWidget($widget)
    {
        $this->widget[] = $widget;
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
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

}
