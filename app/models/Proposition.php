<?php

class Proposition extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdPro;

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
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdAdmin;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $DatePro;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=false)
     */
    public $Status;

    /**
     * Initialize method for model.
     */
    function getIdPro() {
        return $this->IdPro;
    }

    function getIdLi() {
        return $this->IdLi;
    }

    function getIdUser() {
        return $this->IdUser;
    }

    function getIdAdmin() {
        return $this->IdAdmin;
    }

    function getDatePro() {
        return $this->DatePro;
    }

    function getStatus() {
        return $this->Status;
    }

    function setIdPro($IdPro) {
        $this->IdPro = $IdPro;
    }

    function setIdLi($IdLi) {
        $this->IdLi = $IdLi;
    }

    function setIdUser($IdUser) {
        $this->IdUser = $IdUser;
    }

    function setIdAdmin($IdAdmin) {
        $this->IdAdmin = $IdAdmin;
    }

    function setDatePro($DatePro) {
        $this->DatePro = $DatePro;
    }

    function setStatus($Status) {
        $this->Status = $Status;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->hasMany('IdPro', 'Categoriserpro', 'IdPro', ['alias' => 'Categoriserpro']);
        $this->belongsTo('IdAdmin', '\Admin', 'IdAdmin', ['alias' => 'Admin']);
        $this->belongsTo('IdLi', '\Livre', 'IdLi', ['alias' => 'Livre']);
        $this->belongsTo('IdUser', '\User', 'IdUser', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'proposition';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proposition[]|Proposition
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Proposition
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
