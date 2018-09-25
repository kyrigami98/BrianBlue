<?php

class Favoris extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $idFav;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $idLi;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdUser;

    /**
     * Initialize method for model.
     */
    function getIdFav() {
        return $this->idFav;
    }

    function getIdLi() {
        return $this->idLi;
    }

    function getIdUser() {
        return $this->IdUser;
    }

    function setIdFav($idFav) {
        $this->idFav = $idFav;
    }

    function setIdLi($idLi) {
        $this->idLi = $idLi;
    }

    function setIdUser($IdUser) {
        $this->IdUser = $IdUser;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->belongsTo('IdUser', '\User', 'IdUser', ['alias' => 'User']);
        $this->belongsTo('idLi', '\Livre', 'IdLi', ['alias' => 'Livre']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'favoris';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Favoris[]|Favoris
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Favoris
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
