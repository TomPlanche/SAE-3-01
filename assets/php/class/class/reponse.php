<?php

class reponse
{
    public $id;
    public $label;
    public $estCorrecte;

    public function __construct($id, $label, $estCorrecte)
    {
        $this->id = $id;
        $this->label = $label;
        $this->estCorrecte = $estCorrecte;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getEstCorrecte()
    {
        return $this->estCorrecte;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function setEstCorrecte($estCorrecte)
    {
        $this->estCorrecte = $estCorrecte;
    }


}