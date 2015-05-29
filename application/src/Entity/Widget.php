<?php

namespace VT\Entity;

class Widget
{
    private $type;

    public function __construct($type)
    {
        $this->setType($type);

        switch($type) {
            case 'map':
                $this->x1 = '';
                $this->y1 = '';
                $this->x2 = '';
                $this->y2 = '';
                break;
            case 'image':
                $this->path = '';
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}
