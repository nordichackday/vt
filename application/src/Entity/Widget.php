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
                $this->altText = '';
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

    public function jsonSerialize() {
        switch($this->getType()) {
            case 'map':
                return json_encode([
                    'x1' => $this->x1,
                    'y1' => $this->y1,
                    'x2' => $this->x2,
                    'y2' => $this->y2
                ]);
                break;
            case 'image':
                return json_encode([
                    'originalUrl' => $this->path,
                    'altText' => $this->altText]
                );
                break;
        }    }

}
