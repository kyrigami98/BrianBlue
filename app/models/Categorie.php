<?php

class Categorie extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $IdCat;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=false)
     */
    public $LibCat;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $delai;

    /**
     * Initialize method for model.
     */
    function getIdCat() {
        return $this->IdCat;
    }

    function getLibCat() {
        return $this->LibCat;
    }

    function getDelai() {
        return $this->delai;
    }

    function setIdCat($IdCat) {
        $this->IdCat = $IdCat;
    }

    function setLibCat($LibCat) {
        $this->LibCat = $LibCat;
    }

    function setDelai($delai) {
        $this->delai = $delai;
    }

        public function initialize()
    {
        $this->setSchema("brainblue");
        $this->hasMany('IdCat', 'Categoriserlivre', 'IdCat', ['alias' => 'Categoriserlivre']);
        $this->hasMany('IdCat', 'Categoriserpro', 'IdCat', ['alias' => 'Categoriserpro']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categorie';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categorie[]|Categorie
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categorie
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
