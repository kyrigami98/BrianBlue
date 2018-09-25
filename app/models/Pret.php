<?php

class Pret extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $idPret;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdLi;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdUser;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $DatePret;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $DateRetour;

    /**
     * Initialize method for model.
     */
    function getIdPret() {
        return $this->idPret;
    }

    function getIdLi() {
        return $this->IdLi;
    }

    function getIdUser() {
        return $this->IdUser;
    }

    function getDatePret() {
        return $this->DatePret;
    }

    function getDateRetour() {
        return $this->DateRetour;
    }

    function setIdPret($idPret) {
        $this->idPret = $idPret;
    }

    function setIdLi($IdLi) {
        $this->IdLi = $IdLi;
    }

    function setIdUser($IdUser) {
        $this->IdUser = $IdUser;
    }

    function setDatePret($DatePret) {
        $this->DatePret = $DatePret;
    }

    function setDateRetour($DateRetour) {
        $this->DateRetour = $DateRetour;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->belongsTo('idLi', '\Livre', 'IdLi', ['alias' => 'Livre']);
        $this->belongsTo('IdUser', '\User', 'IdUser', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pret';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pret[]|Pret
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pret
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
