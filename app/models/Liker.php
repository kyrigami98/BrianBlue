<?php

class Liker extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdLike;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdUser;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdPub;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $DateLike;

    /**
     * Initialize method for model.
     */
    function getIdLike() {
        return $this->IdLike;
    }

    function getIdUser() {
        return $this->IdUser;
    }

    function getIdPub() {
        return $this->IdPub;
    }

    function getDateLike() {
        return $this->DateLike;
    }

    function setIdLike($IdLike) {
        $this->IdLike = $IdLike;
    }

    function setIdUser($IdUser) {
        $this->IdUser = $IdUser;
    }

    function setIdPub($IdPub) {
        $this->IdPub = $IdPub;
    }

    function setDateLike($DateLike) {
        $this->DateLike = $DateLike;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->belongsTo('IdPub', '\Publication', 'IdPub', ['alias' => 'Publication']);
        $this->belongsTo('IdUser', '\User', 'IdUser', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'liker';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Liker[]|Liker
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Liker
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
