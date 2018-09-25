<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Adapter\Pdo\Mysql;

class userController extends Controller {

    public function indexAction() {

        if ($this->session->has('IdUser')) {

            $req2 = Categorie::find();


            $this->view->cat = $req2;



            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];

            $conec = new Mysql($config);

            $perPage = 3;
            $limt = count($conec->fetchAll("SELECT * from livre WHERE IdLi IN (SELECT idLi from pret WHERE DateRetour>:time AND IdUser=:IdUser)", \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser')
            ]));



            $sql = "SELECT * from livre WHERE IdLi IN (SELECT idLi from pret WHERE DateRetour>:time AND IdUser=:IdUser) ORDER BY IdLi DESC";
            $paginationlink = $this->url->get("user/pretload") . "?page=";
            $page = 1;
            if (!empty($_GET["page"])) {
                $page = $_GET["page"];
            }

            $start = ($page - 1) * $perPage;
            if ($start < 0) {
                $start = 0;
            }
            //die(var_dump($start));


            $query = $sql . " limit " . $start . "," . $perPage;
            $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                "time" => time(),
                "IdUser" => $this->session->get('IdUser')
            ]);
            //die(var_dump($req));


            if (empty($_GET["rowcount"])) {
                $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                            "time" => time(),
                            "IdUser" => $this->session->get('IdUser')
                ]));
            }
            $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser')
            ]));
            $pages = ceil($test / $perPage);


            // die(var_dump($req));

            $output = '';

            //die(var_dump($req));
            foreach ($req as $value) {
                //die(var_dump($value));
                $pret1 = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                            "IdLi" => $value["IdLi"],
                ]));
                $sql1 = "SELECT * from pret WHERE DateRetour>:time AND IdUser=:IdUser AND idLi=:IdLi";
                $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC, [
                    "time" => time(),
                    "IdUser" => $this->session->get('IdUser'),
                    "IdLi" => $value["IdLi"]
                ]);
                //die(var_dump($req1));
                foreach ($req1 as $value1) {


                    // die(var_dump($perpageresult));

                    $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                    $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
                    $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">' . $value["titre"] . '</h4> 
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '">
                    <h7 class="text-muted"> <i class="fa fa-eye"></i><span class="' . $value["IdLi"] . '"> ' . $value["Vues"] . '</span> vues</h7>
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer">

                    
                    <a href="' . $this->url->get($value["lien"]) . '" class="btn btn-primary embed ' . $value["IdLi"] . '" > <i class="fa fa-book"></i> lire</a>
                    <button type="button" class="btn btn-primary emprunt ' . $value["IdLi"] . '" > Emprunter <span class="emprunt' . $value["IdLi"] . '"> ' . $pret1 . '</span></button> 
                    <i class="fa fa-clock-o"></i>' . strftime("%d-%m-%y %X", $value1["DateRetour"]) . '

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> 
            </div>
            <br/>
        </div>';
                    //die(var_dump($output));
                }
            }
            $output .= ' </div>';


            $this->view->pret = $output;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }
    }

    public function pretloadAction() {
        $this->view->disable();
        $config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'brainblue',
        ];

        $conec = new Mysql($config);
        $perPage = 3;
            $limt = count($conec->fetchAll("SELECT * from livre WHERE IdLi IN (SELECT idLi from pret WHERE DateRetour>:time AND IdUser=:IdUser)", \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser')
            ]));



            $sql = "SELECT * from livre WHERE IdLi IN (SELECT idLi from pret WHERE DateRetour>:time AND IdUser=:IdUser) ORDER BY IdLi DESC";
            $paginationlink = $this->url->get("user/pretload") . "?page=";
            $page = 1;
            if (!empty($_GET["page"])) {
                $page = $_GET["page"];
            }

            $start = ($page - 1) * $perPage;
            if ($start < 0) {
                $start = 0;
            }
            //die(var_dump($start));


            $query = $sql . " limit " . $start . "," . $perPage;
            $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                "time" => time(),
                "IdUser" => $this->session->get('IdUser')
            ]);
            //die(var_dump($req));


            if (empty($_GET["rowcount"])) {
                $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                            "time" => time(),
                            "IdUser" => $this->session->get('IdUser')
                ]));
            }
            $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser')
            ]));
            $pages = ceil($test / $perPage);


            // die(var_dump($req));

            $output = '';

            //die(var_dump($req));
            foreach ($req as $value) {
                //die(var_dump($value));
                $pret1 = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                            "IdLi" => $value["IdLi"],
                ]));
                $sql1 = "SELECT * from pret WHERE DateRetour>:time AND IdUser=:IdUser AND idLi=:IdLi";
                $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC, [
                    "time" => time(),
                    "IdUser" => $this->session->get('IdUser'),
                    "IdLi" => $value["IdLi"]
                ]);
                //die(var_dump($req1));
                foreach ($req1 as $value1) {


                    // die(var_dump($perpageresult));

                    $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                    $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
                    $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">' . $value["titre"] . '</h4> 
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '">
                    <h7 class="text-muted"> <i class="fa fa-eye"></i><span class="' . $value["IdLi"] . '"> ' . $value["Vues"] . '</span> vues</h7>
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer">

                    
                    <a href="' . $this->url->get($value["lien"]) . '" class="btn btn-primary embed ' . $value["IdLi"] . '" > <i class="fa fa-book"></i> lire</a>
                    <button type="button" class="btn btn-primary emprunt ' . $value["IdLi"] . '" > Emprunter <span class="emprunt' . $value["IdLi"] . '"> ' . $pret1 . '</span></button> 
                    <i class="fa fa-clock-o"></i>' . strftime("%d-%m-%y %X", $value1["DateRetour"]) . '

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> 
            </div>
            <br/>
        </div>';
                    //die(var_dump($output));
                }
            }
            $output .= ' </div>';


        //die(var_dump($output));
        // die(var_dump($perpageresult));
        echo $output;
    }

    public function modifierAction() {
        
    }

    public function FavorisAction() {
        if ($this->session->has('IdUser')) {
            $req2 = Categorie::find();


            $this->view->cat = $req2;



            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];

            $conec = new Mysql($config);

            $perPage = 3;
            $limt = count($conec->fetchAll("SELECT * from favoris WHERE IdUser=:IdUser", \Phalcon\Db::FETCH_ASSOC, [
                        "IdUser" => $this->session->get('IdUser')
            ]));



            $sql = "SELECT * from favoris WHERE IdUser=:IdUser ORDER BY IdFav DESC";
            $paginationlink = $this->url->get("user/favorisload") . "?page=";
            $page = 1;
            if (!empty($_GET["page"])) {
                $page = $_GET["page"];
            }

            $start = ($page - 1) * $perPage;
            if ($start < 0) {
                $start = 0;
            }
            //die(var_dump($start));


            $query = $sql . " limit " . $start . "," . $perPage;
            $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                "IdUser" => $this->session->get('IdUser')
            ]);
            //die(var_dump($req));


            if (empty($_GET["rowcount"])) {
                $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                            "IdUser" => $this->session->get('IdUser')
                ]));
            }
            $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, [
                        "IdUser" => $this->session->get('IdUser')
            ]));
            $pages = ceil($test / $perPage);


            // die(var_dump($req));

            $output = '';

            $output .= '<div class="row">';
            foreach ($req as $value1) {
                $req1 = Livre::findFirst([
                            "(IdLi=:IdLi:)", "bind" => [
                                "IdLi" => $value1["idLi"],
                            ]
                ]);

                $pret = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                            "IdLi" => $req1->getIdLi(),
                ]));

                $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
                $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                   <h4 class="card-title">' . $req1->getTitre() . '</h4> 
                       <h5 class="card-title"> Auteur: ' . $req1->getAuteur() . '</h5>  
                    <img height="120px" src="' . $this->url->get($req1->getCover()) . '"/>
                    
                    <p class="card-text">' . $req1->getDescription() . '</p>
                </div>
                <div class="card-footer">
                     <button type="button" class="btn btn-warning favoris ' . $req1->getIdLi() . '" id="favoris' . $req1->getIdLi() . '" >&#9733;</button>
                   <button type="button" class="btn btn-primary emprunt ' . $req1->getIdLi() . '" > Emprunter <span class="emprunt' . $req1->getIdLi() . '"> ' . $pret . '</span></button>
     
                   

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
            }

            $output .= ' </div>';



            // die(var_dump($perpageresult));
            $this->view->pub = $output;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }
    }

    public function favorisloadAction() {
        $this->view->disable();
        $config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'brainblue',
        ];

        $conec = new Mysql($config);

        $perPage = 3;
        $limt = count($conec->fetchAll("SELECT * from favoris WHERE IdUser=:IdUser", \Phalcon\Db::FETCH_ASSOC, [
                    "IdUser" => $this->session->get('IdUser')
        ]));



        $sql = "SELECT * from favoris WHERE IdUser=:IdUser ORDER BY IdFav DESC";
        $paginationlink = $this->url->get("user/favorisload") . "?page=";
        $page = 1;
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perPage;
        if ($start < 0) {
            $start = 0;
        }
        //die(var_dump($start));


        $query = $sql . " limit " . $start . "," . $perPage;
        $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
            "IdUser" => $this->session->get('IdUser')
        ]);
        //die(var_dump($req));


        if (empty($_GET["rowcount"])) {
            $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                        "IdUser" => $this->session->get('IdUser')
            ]));
        }
        $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, [
                    "IdUser" => $this->session->get('IdUser')
        ]));
        $pages = ceil($test / $perPage);


        // die(var_dump($req));

        $output = '';

        $output .= '<div class="row">';
        foreach ($req as $value1) {
            $req1 = Livre::findFirst([
                        "(IdLi=:IdLi:)", "bind" => [
                            "IdLi" => $value1["idLi"],
                        ]
            ]);

            $pret = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                        "IdLi" => $req1->getIdLi(),
            ]));

            $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
            $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
            $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                   <h4 class="card-title">' . $req1->getTitre() . '</h4> 
                       <h5 class="card-title"> Auteur: ' . $req1->getAuteur() . '</h5>  
                    <img height="120px" src="' . $this->url->get($req1->getCover()) . '"/>
                    
                    <p class="card-text">' . $req1->getDescription() . '</p>
                </div>
                <div class="card-footer">
                     <button type="button" class="btn btn-warning favoris ' . $req1->getIdLi() . '" id="favoris' . $req1->getIdLi() . '" >&#9733;</button>
                   <button type="button" class="btn btn-primary emprunt ' . $req1->getIdLi() . '" > Emprunter <span class="emprunt' . $req1->getIdLi() . '"> ' . $pret . '</span></button>
     
                   

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
        }

        $output .= ' </div>';




        //die(var_dump($output));
        // die(var_dump($perpageresult));
        echo $output;
    }

    public function searchfavorisAction() {

        $this->view->disable();
        if (isset($_GET['pourc']) && $this->session->has('IdUser')) {
            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];


            $titre = $_GET['pourc'];
            $conec = new Mysql($config);
            $req = $conec->fetchAll("SELECT * from livre WHERE IdLi IN (SELECT idLi from favoris WHERE IdUser=:IdUser) AND titre LIKE :titre", \Phalcon\Db::FETCH_ASSOC, [
                "IdUser" => $this->session->get('IdUser'),
                "titre" => "%" . $titre . "%"
            ]);

//die(var_dump($req));
            if ($req != NULL) {
                $output = '';
                $output .= '<div class="row">';
                foreach ($req as $value) {

                    $pret = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                                "IdLi" => $value["IdLi"],
                    ]));
                    $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                   <h4 class="card-title">' . $value["titre"] . '</h4> 
                       <h5 class="card-title"> Auteur: ' . $value["auteur"] . '</h5>  
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '"/>
                    
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer">
                     <button type="button" class="btn btn-warning favoris ' . $value["IdLi"] . '" id="favoris' . $value["IdLi"] . '" >&#9734;</button>
                   <button type="button" class="btn btn-primary emprunt ' . $value["IdLi"] . '" > Emprunter <span class="emprunt' . $value["IdLi"] . '"> ' . $pret . '</span></button>
     
                   

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
                }
                $output .= ' </div>';
// die(var_dump($data));

                echo $output;
            } else {
                echo '<h7 class = "col-md-12 text-muted text-center" style = "color:black; "> Aucun résultat </h7></div>';
            }
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));
        }
    }

    public function searchcatfavorisAction() {

        $this->view->disable();
        if (isset($_GET['pourc']) && $this->session->has('IdUser')) {
            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];


            $id = $_GET['pourc'];
            $conec = new Mysql($config);
            $req = $conec->fetchAll("SELECT * from livre WHERE IdLi IN (SELECT idLi from favoris WHERE IdUser=:IdUser) AND IdCat=:IdCat", \Phalcon\Db::FETCH_ASSOC, [
                "IdUser" => $this->session->get('IdUser'),
                "IdCat" => $id
            ]);

//die(var_dump($req));
            if ($req != NULL) {
                $output = '';
                $output .= '<div class="row">';
                foreach ($req as $value) {

                    $pret = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                                "IdLi" => $value["IdLi"],
                    ]));
                    $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                   <h4 class="card-title">' . $value["titre"] . '</h4> 
                       <h5 class="card-title"> Auteur: ' . $value["auteur"] . '</h5>  
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '"/>
                    
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer">
                     <button type="button" class="btn btn-warning favoris ' . $value["IdLi"] . '" id="favoris' . $value["IdLi"] . '" >&#9734;</button>
                   <button type="button" class="btn btn-primary emprunt ' . $value["IdLi"] . '" > Emprunter <span class="emprunt' . $value["IdLi"] . '"> ' . $pret . '</span></button>
     
                   

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
                }
                $output .= ' </div>';
// die(var_dump($data));

                echo $output;
            } else {
                echo '<h7 class = "col-md-12 text-muted text-center" style = "color:black; "> Aucun résultat </h7></div>';
            }
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));
        }
    }

    public function vueAction() {
        $this->view->disable();
        $id = $_GET["IdLi"];

        $req = Livre::findFirst([
                    "IdLi = :id:", "bind" => [
                        "id" => $id,
                    ]
        ]);
        if ($req != NULL) {
            $i = (int) $req->Vues;
            $i++;
            $req->update(['Vues' => $i]);
            echo $req->Vues;
        }
    }

    public function searchlivreAction() {

        $this->view->disable();
        if (isset($_GET['pourc']) && $this->session->has('IdUser')) {
            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];


            $titre = $_GET['pourc'];
            $conec = new Mysql($config);
            $req = $conec->fetchAll("SELECT * from livre WHERE IdLi IN (SELECT idLi from pret WHERE DateRetour>:time AND IdUser=:IdUser) AND titre LIKE :titre", \Phalcon\Db::FETCH_ASSOC, [
                "time" => time(),
                "IdUser" => $this->session->get('IdUser'),
                "titre" => "%" . $titre . "%"
            ]);

//die(var_dump($req));
            if ($req != NULL) {
                $output = '';

                foreach ($req as $value) {
                    //die(var_dump($value));
                    $pret1 = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                                "IdLi" => $value["IdLi"],
                    ]));
                    $sql1 = "SELECT * from pret WHERE DateRetour>:time AND IdUser=:IdUser AND idLi=:IdLi";
                    $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser'),
                        "IdLi" => $value["IdLi"]
                    ]);
                    //die(var_dump($req1));
                    foreach ($req1 as $value1) {


                        // die(var_dump($perpageresult));

                        $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">' . $value["titre"] . '</h4> 
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '">
                    <h7 class="text-muted"> <i class="fa fa-eye"></i><span class="' . $value["IdLi"] . '"> ' . $value["Vues"] . '</span> vues</h7>
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer">

                    
                    <a href="' . $this->url->get($value["lien"]) . '" class="btn btn-primary embed ' . $value["IdLi"] . '" > <i class="fa fa-book"></i> lire</a>
                    <button type="button" class="btn btn-primary emprunt ' . $value["IdLi"] . '" > Emprunter <span class="emprunt' . $value["IdLi"] . '"> ' . $pret1 . '</span></button> 
                    <i class="fa fa-clock-o"></i>' . strftime("%d-%m-%y %X", $value1["DateRetour"]) . '

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> 
            </div>
            <br/>
        </div>';
                        //die(var_dump($output));
                    }
                }
                $output .= ' </div>';

// die(var_dump($data));

                echo $output;
            } else {
                echo '<h7 class = "col-md-12 text-muted text-center" style = "color:black; "> Aucun résultat </h7></div>';
            }
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));
        }
    }

    public function searchcatlivreAction() {

        $this->view->disable();
        if (isset($_GET['pourc']) && $this->session->has('IdUser')) {
            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];


            $id = $_GET['pourc'];
            $conec = new Mysql($config);
            $req = $conec->fetchAll("SELECT * from livre WHERE IdLi IN (SELECT idLi from pret WHERE DateRetour>:time AND IdUser=:IdUser) AND IdCat=:IdCat", \Phalcon\Db::FETCH_ASSOC, [
                "time" => time(),
                "IdUser" => $this->session->get('IdUser'),
                "IdCat" => $id
            ]);

//die(var_dump($req));
            if ($req != NULL) {
                $output = '';

                foreach ($req as $value) {
                    //die(var_dump($value));
                    $pret1 = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                                "IdLi" => $value["IdLi"],
                    ]));
                    $sql1 = "SELECT * from pret WHERE DateRetour>:time AND IdUser=:IdUser AND idLi=:IdLi";
                    $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser'),
                        "IdLi" => $value["IdLi"]
                    ]);
                    //die(var_dump($req1));
                    foreach ($req1 as $value1) {


                        // die(var_dump($perpageresult));

                        
                        $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">' . $value["titre"] . '</h4> 
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '">
                    <h7 class="text-muted"> <i class="fa fa-eye"></i><span class="' . $value["IdLi"] . '"> ' . $value["Vues"] . '</span> vues</h7>
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer">

                    
                    <a href="' . $this->url->get($value["lien"]) . '" class="btn btn-primary embed ' . $value["IdLi"] . '" > <i class="fa fa-book"></i> lire</a>
                    <button type="button" class="btn btn-primary emprunt ' . $value["IdLi"] . '" > Emprunter <span class="emprunt' . $value["IdLi"] . '"> ' . $pret1 . '</span></button> 
                    <i class="fa fa-clock-o"></i>' . strftime("%d-%m-%y %X", $value1["DateRetour"]) . '

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> 
            </div>
            <br/>
        </div>';
                        //die(var_dump($output));
                    }
                }
                $output .= ' </div>';

// die(var_dump($data));

                echo $output;
            } else {
                echo '<h7 class = "col-md-12 text-muted text-center" style = "color:black; "> Aucun résultat </h7></div>';
            }
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));
        }
    }

}
