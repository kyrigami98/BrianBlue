<?php

class Livre extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdLi;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdCat;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $titre;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $auteur;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $cover;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $lien;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $description;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=true)
     */
    public $status;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $Vues;

    /**
     * Initialize method for model.
     */
    function getIdLi() {
        return $this->IdLi;
    }

    function getIdCat() {
        return $this->IdCat;
    }

    function getTitre() {
        return $this->titre;
    }

    function getAuteur() {
        return $this->auteur;
    }

    function getCover() {
        return $this->cover;
    }

    function getLien() {
        return $this->lien;
    }

    function getDescription() {
        return $this->description;
    }

    function getStatus() {
        return $this->status;
    }

    function getVues() {
        return $this->Vues;
    }

    function setIdLi($IdLi) {
        $this->IdLi = $IdLi;
    }

    function setIdCat($IdCat) {
        $this->IdCat = $IdCat;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setAuteur($auteur) {
        $this->auteur = $auteur;
    }

    function setCover($cover) {
        $this->cover = $cover;
    }

    function setLien($lien) {
        $this->lien = $lien;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setVues($Vues) {
        $this->Vues = $Vues;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->hasMany('IdLi', 'Favoris', 'idLi', ['alias' => 'Favoris']);
        $this->hasMany('IdLi', 'Pret', 'idLi', ['alias' => 'Pret']);
        $this->hasMany('IdLi', 'Proposition', 'IdLi', ['alias' => 'Proposition']);
        $this->belongsTo('IdCat', '\Categorie', 'IdCat', ['alias' => 'Categorie']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'livre';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Livre[]|Livre
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Livre
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
