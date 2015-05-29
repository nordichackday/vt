<?php

namespace VT\Entity;

class Map
{
    private $x1;
    private $y1;
    private $x2;
    private $y2;

    /**
     * @return mixed
     */
    public function getX1()
    {
        return $this->x1;
    }

    /**
     * @param mixed $x1
     */
    public function setX1($x1)
    {
        $this->x1 = $x1;
    }

    /**
     * @return mixed
     */
    public function getY1()
    {
        return $this->y1;
    }

    /**
     * @param mixed $y1
     */
    public function setY1($y1)
    {
        $this->y1 = $y1;
    }

    /**
     * @return mixed
     */
    public function getX2()
    {
        return $this->x2;
    }

    /**
     * @param mixed $x2
     */
    public function setX2($x2)
    {
        $this->x2 = $x2;
    }

    /**
     * @return mixed
     */
    public function getY2()
    {
        return $this->y2;
    }

    /**
     * @param mixed $y2
     */
    public function setY2($y2)
    {
        $this->y2 = $y2;
    }


}
