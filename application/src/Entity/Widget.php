<?php

namespace VT\Entity;

class Widget
{
    private $id;
    private $type;
    private $data;

    public function __construct($type, $data = false)
    {
        $type = strtolower($type);

        $this->setType($type);

        switch($type) {
            case 'map':
                $this->x1 = '';
                $this->y1 = '';
                $this->x2 = '';
                $this->y2 = '';
                break;
            case 'image':
                $this->originalUrl = '';
                $this->altText = '';
                break;
        }

        if($data) {
            $data = json_decode($data);
            foreach($data as $key => $value) {
                $this->$key = $value;
            }
        }

        $this->setData();
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData()
    {
        $this->data = $this->jsonSerialize();
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
                    'originalUrl' => $this->originalUrl,
                    'altText' => $this->altText
                ]);
                break;
        }    }

}
