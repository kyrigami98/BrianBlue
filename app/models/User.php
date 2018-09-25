<?php

class User extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdUser;

    /**
     *
     * @var string
     * @Column(type="string", length=22, nullable=false)
     */
    public $Nom;

    /**
     *
     * @var string
     * @Column(type="string", length=22, nullable=false)
     */
    public $Prenom;

    /**
     *
     * @var string
     * @Column(type="string", length=40, nullable=false)
     */
    public $Mail;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $DateNaiss;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $Password;

    /**
     *
     * @var string
     * @Column(type="string", length=12, nullable=true)
     */
    public $statut;

    /**
     * Initialize method for model.
     */
    function getIdUser() {
        return $this->IdUser;
    }

    function getNom() {
        return $this->Nom;
    }

    function getPrenom() {
        return $this->Prenom;
    }

    function getMail() {
        return $this->Mail;
    }

    function getDateNaiss() {
        return $this->DateNaiss;
    }

    function getPassword() {
        return $this->Password;
    }

    function getStatut() {
        return $this->statut;
    }

    function setIdUser($IdUser) {
        $this->IdUser = $IdUser;
    }

    function setNom($Nom) {
        $this->Nom = $Nom;
    }

    function setPrenom($Prenom) {
        $this->Prenom = $Prenom;
    }

    function setMail($Mail) {
        $this->Mail = $Mail;
    }

    function setDateNaiss($DateNaiss) {
        $this->DateNaiss = $DateNaiss;
    }

    function setPassword($Password) {
        $this->Password = $Password;
    }

    function setStatut($statut) {
        $this->statut = $statut;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->hasMany('IdUser', 'Admin', 'IdUser', ['alias' => 'Admin']);
        $this->hasMany('IdUser', 'Auteur', 'IdUser', ['alias' => 'Auteur']);
        $this->hasMany('IdUser', 'CommenterPub', 'IdUser', ['alias' => 'CommenterPub']);
        $this->hasMany('IdUser', 'Favoris', 'IdUser', ['alias' => 'Favoris']);
        $this->hasMany('IdUser', 'Liker', 'IdUser', ['alias' => 'Liker']);
        $this->hasMany('IdUser', 'Pret', 'IdUser', ['alias' => 'Pret']);
        $this->hasMany('IdUser', 'Proposition', 'IdUser', ['alias' => 'Proposition']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
