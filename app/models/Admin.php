<?php

class Admin extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdAdmin;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $Passwordadmin;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=false)
     */
    public $pseudoadmin;

    /**
     * Initialize method for model.
     */
    function getIdAdmin() {
        return $this->IdAdmin;
    }

    function getPasswordadmin() {
        return $this->Passwordadmin;
    }

    function getPseudoadmin() {
        return $this->pseudoadmin;
    }

    function setIdAdmin($IdAdmin) {
        $this->IdAdmin = $IdAdmin;
    }

    function setPasswordadmin($Passwordadmin) {
        $this->Passwordadmin = $Passwordadmin;
    }

    function setPseudoadmin($pseudoadmin) {
        $this->pseudoadmin = $pseudoadmin;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->hasMany('IdAdmin', 'Proposition', 'IdAdmin', ['alias' => 'Proposition']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'admin';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Admin[]|Admin
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Admin
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
