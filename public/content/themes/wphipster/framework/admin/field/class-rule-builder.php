<?php
namespace wp_hipster\admin\field;


use wp_hipster\core\Builder;

class Rule_Builder implements Builder
{

    private $required;
    private $integer;
    private $email;
    private $min;
    private $max;

    /**
     * @param mixed $required
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @param mixed $integer
     * @return $this
     */
    public function setInteger($integer)
    {
        $this->integer = $integer;
        return $this;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $min
     * @return $this
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @param mixed $max
     * @return $this
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    function build()
    {
//        return new Rule($this->required, $this->integer, $this->email, $this->min, $this->max);
    }
}