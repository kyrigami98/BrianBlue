<?php

class CommenterPub extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdCom;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdPub;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $text;

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
    public $DateCom;

    /**
     * Initialize method for model.
     */
    function getIdCom() {
        return $this->IdCom;
    }

    function getIdPub() {
        return $this->IdPub;
    }

    function getText() {
        return $this->text;
    }

    function getIdUser() {
        return $this->IdUser;
    }

    function getDateCom() {
        return $this->DateCom;
    }

    function setIdCom($IdCom) {
        $this->IdCom = $IdCom;
    }

    function setIdPub($IdPub) {
        $this->IdPub = $IdPub;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setIdUser($IdUser) {
        $this->IdUser = $IdUser;
    }

    function setDateCom($DateCom) {
        $this->DateCom = $DateCom;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->belongsTo('IdUser', '\User', 'IdUser', ['alias' => 'User']);
        $this->belongsTo('IdPub', '\Publication', 'IdPub', ['alias' => 'Publication']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'commenter_pub';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CommenterPub[]|CommenterPub
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CommenterPub
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
