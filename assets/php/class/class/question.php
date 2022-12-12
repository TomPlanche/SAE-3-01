<?php

class question
{
    public $id;
    public $titre;
    public $unType;
    public $uneDifficulte;
    public $mesReponses;
    public $mesTags;

    public function __construct($id, $titre, $unType, $uneDifficulte, $mesReponses, $mesTags)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->unType = $unType;
        $this->uneDifficulte = $uneDifficulte;
        $this->mesReponses = $mesReponses;
        $this->mesTags = $mesTags;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getUnType()
    {
        return $this->unType;
    }

    public function getUneDifficulte()
    {
        return $this->uneDifficulte;
    }

    public function getMesReponses()
    {
        return $this->mesReponses;
    }

    public function getMesTags()
    {
        return $this->mesTags;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setUnType($unType)
    {
        $this->unType = $unType;
    }

    public function setUneDifficulte($uneDifficulte)
    {
        $this->uneDifficulte = $uneDifficulte;
    }

    public function addReponse($uneReponse)
    {
        $this->mesReponses += $uneReponse;
    }

    public function setMesReponses($mesReponses)
    {
        $this->mesReponses = $mesReponses;
    }

    public function addTag($unTag)
    {
        $this->mesTags += $unTag;
    }

    public function setMesTags($mesTags)
    {
        $this->mesTags = $mesTags;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->titre;
    }

    public function getReponseCorrecte()
    {
        $listeReponses = $this->mesReponses;
        foreach ($listeReponses as $uneReponse)
        {
            if ($uneReponse->getEstCorrecte() == 1)
            {
                $listeReponses += $uneReponse;
            }
        }
        return $listeReponses;
    }

    public function getReponseIncorrecte()
    {
        $listeReponses = $this->mesReponses;
        foreach ($listeReponses as $uneReponse)
        {
            if ($uneReponse->getCorrecte() == 0)
            {
                $listeReponses += $uneReponse;
            }
        }
        return $listeReponses;
    }


}