<?php
namespace Oeuvres;

class Livre extends Oeuvre{
    /* attributs */
    private $resume;
    private $format;
    private $genre;
    private $isbn;

    /* contructeur */
    public function __construct($titre, $description = '', $resume = '', $format = '', $genre = '', $isbn = '')
    {
        parent::__construct($titre, $description);
        $this->resume = $resume;
        $this->format = $format;
        $this->genre = $genre;
        $this->isbn = $isbn;
    }
    /* assesseurs / mutateurs */
    
    /**
     * Get the value of resume
     */ 
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set the value of resume
     *
     * @return  self
     */ 
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get the value of format
     */ 
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set the value of format
     *
     * @return  self
     */ 
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get the value of genre
     */ 
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set the value of genre
     *
     * @return  self
     */ 
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get the value of isbn
     */ 
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */ 
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /* méthodes */

}