<?php

class Publication extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdPub;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdAut;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $LienLivre;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $cover;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $text;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $DatePub;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=false)
     */
    public $Titre;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $Vues;

    /**
     * Initialize method for model.
     */
    function getIdPub() {
        return $this->IdPub;
    }

    function getIdAut() {
        return $this->IdAut;
    }

    function getLienLivre() {
        return $this->LienLivre;
    }

    function getCover() {
        return $this->cover;
    }

    function getText() {
        return $this->text;
    }

    function getDatePub() {
        return $this->DatePub;
    }

    function getTitre() {
        return $this->Titre;
    }

    function getVues() {
        return $this->Vues;
    }

    function setIdPub($IdPub) {
        $this->IdPub = $IdPub;
    }

    function setIdAut($IdAut) {
        $this->IdAut = $IdAut;
    }

    function setLienLivre($LienLivre) {
        $this->LienLivre = $LienLivre;
    }

    function setCover($cover) {
        $this->cover = $cover;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setDatePub($DatePub) {
        $this->DatePub = $DatePub;
    }

    function setTitre($Titre) {
        $this->Titre = $Titre;
    }

    function setVues($Vues) {
        $this->Vues = $Vues;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->hasMany('IdPub', 'CommenterPub', 'IdPub', ['alias' => 'CommenterPub']);
        $this->hasMany('IdPub', 'Liker', 'IdPub', ['alias' => 'Liker']);
        $this->belongsTo('IdAut', '\Auteur', 'IdAut', ['alias' => 'Auteur']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'publication';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Publication[]|Publication
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Publication
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
