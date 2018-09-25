<?php

class Auteur extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=true)
     */
    public $profil;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdAut;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $bibiographie;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdUser;

    /**
     * Initialize method for model.
     */
    function getProfil() {
        return $this->profil;
    }

    function getIdAut() {
        return $this->IdAut;
    }

    function getBibiographie() {
        return $this->bibiographie;
    }

    function getIdUser() {
        return $this->IdUser;
    }

    function setProfil($profil) {
        $this->profil = $profil;
    }

    function setIdAut($IdAut) {
        $this->IdAut = $IdAut;
    }

    function setBibiographie($bibiographie) {
        $this->bibiographie = $bibiographie;
    }

    function setIdUser($IdUser) {
        $this->IdUser = $IdUser;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->hasMany('IdAut', 'Publication', 'IdAut', ['alias' => 'Publication']);
        $this->belongsTo('IdUser', '\User', 'IdUser', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'auteur';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Auteur[]|Auteur
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Auteur
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
