<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Adapter\Pdo\Mysql;

class livreController extends Controller {

    public function indexAction() {
        
    }

    public function BibliothequeAction() {
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
            $limt = count($conec->fetchAll("SELECT * from livre WHERE IdLi NOT IN (SELECT idLi from pret WHERE DateRetour<=:time AND IdUser=:IdUser)", \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser')
            ]));



            $sql = "SELECT * from livre WHERE IdLi NOT IN (SELECT idLi from pret WHERE DateRetour<=:time AND IdUser=:IdUser) ORDER BY IdLi DESC";
            $paginationlink = $this->url->get("livre/livreload") . "?page=";
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

            
            foreach ($req as $value) {
                $pret = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                            "IdLi" => $value["IdLi"],
                ]));
                $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
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
            



            // die(var_dump($perpageresult));
            $this->view->pub = $output;
            $sql1 = "SELECT idLi from pret GROUP BY idLi ORDER BY COUNT(*) DESC";
            $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC);
            //die(var_dump($req1));
            $tab = [];
            foreach ($req1 as $value) {
                $req2 = Livre::findFirst([
                            "(IdLi=:IdLi:) ", "bind" => [
                                "IdLi" => $value["idLi"],
                            ]
                ]);
                $tab[] = $req2;
            }
            $this->view->mostborrow = $tab;
        } else {
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
            $limt = count($conec->fetchAll("SELECT * from livre", \Phalcon\Db::FETCH_ASSOC));



            $sql = "SELECT * from livre ORDER BY IdLi DESC";
            $paginationlink = $this->url->get("livre/livreload") . "?page=";
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
            $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC);
            //die(var_dump($req));


            if (empty($_GET["rowcount"])) {
                $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC));
            }
            $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC));
            $pages = ceil($test / $perPage);


            // die(var_dump($req));

            $output = '';

            
            foreach ($req as $value) {

                $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
                $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                   <h4 class="card-title">' . $value["titre"] . '</h4> 
                       <h5 class="card-title"> Auteur: ' . $value["auteur"] . '</h5>  
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '"/>
                    
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer" style="position:absolute;bottom:1px; right:10px;  font-size:50px; ">    
                <img height="80px" src="/BrainBlue/public/img/cad1.png">           
                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
            }
            



            // die(var_dump($perpageresult));
            $this->view->pub = $output;
            $sql1 = "SELECT idLi from pret GROUP BY idLi ORDER BY COUNT(*) DESC";
            $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC);
            //die(var_dump($req1));
            $tab = [];
            foreach ($req1 as $value) {
                $req2 = Livre::findFirst([
                            "(IdLi=:IdLi:) ", "bind" => [
                                "IdLi" => $value["idLi"],
                            ]
                ]);
                $tab[] = $req2;
            }
            $this->view->mostborrow = $tab;
        }
    }

    public function livreloadAction() {

        $this->view->disable();
        $config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'brainblue',
        ];

        $conec = new Mysql($config);

        if ($this->session->has('IdUser')) {

            $perPage = 3;
            $limt = count($conec->fetchAll("SELECT * from livre WHERE IdLi NOT IN (SELECT idLi from pret WHERE DateRetour<=:time AND IdUser=:IdUser)", \Phalcon\Db::FETCH_ASSOC, [
                        "time" => time(),
                        "IdUser" => $this->session->get('IdUser')
            ]));



            $sql = "SELECT * from livre WHERE IdLi NOT IN (SELECT idLi from pret WHERE DateRetour<=:time AND IdUser=:IdUser) ORDER BY IdLi DESC";
            $paginationlink = $this->url->get("livre/livreload") . "?page=";
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

            
            foreach ($req as $value) {
                $pret = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                            "IdLi" => $value["IdLi"],
                ]));
                $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
                $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                   <h4 class="card-title">' . $value["titre"] . '</h4> 
                       <h5 class="card-title"> Auteur: ' . $value["auteur"] . '</h5>  
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '"/>
                   
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer">
                     <button type="button" class="btn btn-warning favoris ' . $value["IdLi"] . '" >&#9734;</button>
                   <button type="button" class="btn btn-primary emprunt ' . $value["IdLi"] . '" > Emprunter <span class="emprunt' . $value["IdLi"] . '"> ' . $pret . '</span></button>
                    
     
                   

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
            }
            
        } else {

            $perPage = 3;
            $limt = count($conec->fetchAll("SELECT * from livre", \Phalcon\Db::FETCH_ASSOC));



            $sql = "SELECT * from livre ORDER BY IdLi DESC";
            $paginationlink = $this->url->get("livre/livreload") . "?page=";
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
            $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC);
            //die(var_dump($req));


            if (empty($_GET["rowcount"])) {
                $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC));
            }
            $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC));
            $pages = ceil($test / $perPage);


            // die(var_dump($req));

            $output = '';

            
            foreach ($req as $value) {

                $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
                $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                   <h4 class="card-title">' . $value["titre"] . '</h4> 
                       <h5 class="card-title"> Auteur: ' . $value["auteur"] . '</h5>  
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '"/>
                    
                    <p class="card-text">' . $value["description"] . '</p>
                </div>
                <div class="card-footer" style="position:absolute;bottom:1px; right:10px;  font-size:50px; ">    
                <img height="80px" src="/BrainBlue/public/img/cad1.png">           
                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
            }
            



            // die(var_dump($perpageresult));
            $this->view->pub = $output;
            $sql1 = "SELECT idLi from pret GROUP BY idLi ORDER BY COUNT(*) DESC";
            $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC);
            //die(var_dump($req1));
            $tab = [];
            foreach ($req1 as $value) {
                $req2 = Livre::findFirst([
                            "(IdLi=:IdLi:) ", "bind" => [
                                "IdLi" => $value["idLi"],
                            ]
                ]);
                $tab[] = $req2;
            }
            $this->view->mostborrow = $tab;
        }



        //die(var_dump($output));
        // die(var_dump($perpageresult));
        echo $output;
    }

    public function empruntAction() {

        if ($this->session->has('IdUser')) {
            $this->view->disable();
            $output = '';
            if (isset($_GET["IdLi"])) {

                $req = Pret::findFirst([
                            "(IdLi=:IdLi:) AND (DateRetour >= :time:) AND (IdUser = :IdUser:)", "bind" => [
                                "IdLi" => $_GET["IdLi"],
                                "time" => time(),
                                "IdUser" => $this->session->get('IdUser'),
                            ]
                ]);
                $id = $_GET["IdLi"];
                // die( var_dump($req));
                if (!$req) {

                    $req1 = Livre::findFirst([
                                "(IdLi=:IdLi:)", "bind" => [
                                    "IdLi" => $_GET["IdLi"],
                                ]
                    ]);

                    $req2 = Categorie::findFirst([
                                "(IdCat=:IdCat:)", "bind" => [
                                    "IdCat" => $req1->getIdCat(),
                                ]
                    ]);


                    $limit = $req2->getDelai();

                    $pret = new Pret();
                    $pret->DatePret = strtotime(date('Y-m-d H:i:s'));
                    $pret->IdLi = $id;
                    $pret->IdUser = $this->session->get('IdUser');

                    $pret->DateRetour = strtotime(date('Y-m-d H:i:s', strtotime("+" . $limit . " week")));

                    $var = $pret->save();
                } else {
                    // die(var_dump($req));

                    $req->delete();
                }
                $config = [
                    'host' => 'localhost',
                    'username' => 'root',
                    'password' => '',
                    'dbname' => 'brainblue',
                ];

                $conec = new Mysql($config);
                $compte = count($conec->fetchAll("SELECT * from pret WHERE IdLi=:IdLi", \Phalcon\Db::FETCH_ASSOC, [
                            "IdLi" => $id,
                ]));
                $output = $compte;
            }
            echo $output;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }
    }

    public function favorisAction() {

        if ($this->session->has('IdUser')) {
            $this->view->disable();
            $output = '';
            if (isset($_GET["IdLi"])) {

                $req = Favoris::findFirst([
                            "(idLi=:IdLi:)AND (IdUser = :IdUser:)", "bind" => [
                                "IdLi" => $_GET["IdLi"],
                                "IdUser" => $this->session->get('IdUser'),
                            ]
                ]);
                $id = $_GET["IdLi"];
                // die( var_dump($req));
                if (!$req) {


                    $favoris = new Favoris();
                    $favoris->idLi = $id;
                    $favoris->IdUser = $this->session->get('IdUser');
                    $var = $favoris->save();
                    $output = "&#9733;";
                } else {
                    // die(var_dump($req));

                    $req->delete();
                    $output = "&#9734;";
                }
            }
            echo $output;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
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
            $req = $conec->fetchAll("SELECT * from livre WHERE IdLi NOT IN (SELECT idLi from pret WHERE DateRetour<=:time AND IdUser=:IdUser) AND titre LIKE :titre", \Phalcon\Db::FETCH_ASSOC, [
                "time" => time(),
                "IdUser" => $this->session->get('IdUser'),
                "titre" => "%" . $titre . "%"
            ]);

//die(var_dump($req));
            if ($req != NULL) {
                $output = '';
                
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
            $req = $conec->fetchAll("SELECT * from livre WHERE IdLi NOT IN (SELECT idLi from pret WHERE DateRetour<=:time AND IdUser=:IdUser) AND IdCat=:IdCat", \Phalcon\Db::FETCH_ASSOC, [
                "time" => time(),
                "IdUser" => $this->session->get('IdUser'),
                "IdCat" => $id
            ]);

//die(var_dump($req));
            if ($req != NULL) {
                $output = '';
                
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
                
// die(var_dump($data));

                echo $output;
            } else {
                echo '<h7 class = "col-md-12 text-muted text-center" style = "color:black; "> Aucun résultat </h7></div>';
            }
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));
        }
    }

}
