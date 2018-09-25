<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Adapter\Pdo\Mysql;

class DefaultController extends Controller {

    public function indexAction() {
        if ($this->session->has("IdUser")) {

            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];

            $conec = new Mysql($config);

            $perPage = 3;
            $limt = count($conec->fetchAll("SELECT * from publication", \Phalcon\Db::FETCH_ASSOC));



            $sql = "SELECT * from publication ORDER BY IdPub DESC";
            $paginationlink = $this->url->get("Default/pubload") . "?page=";
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

            $output .= '<div class="row">';
            foreach ($req as $value) {
                $like = count($conec->fetchAll("SELECT * from liker WHERE IdPub=:IdPub", \Phalcon\Db::FETCH_ASSOC, [
                            "IdPub" => $value["IdPub"],
                ]));
                $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
                $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
                $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">' . $value["Titre"] . '</h4> 
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '"/>
                    <h7 class="text-muted"> <i class="fa fa-eye"></i><span class="' . $value["IdPub"] . '"> ' . $value["Vues"] . '</span> vues</h7>
                    <p class="card-text">' . $value["text"] . '</p>
                </div>
                <div class="card-footer">

                    <button type="button" class="btn btn-danger like ' . $value["IdPub"] . '" > <span class="like' . $value["IdPub"] . '"> ' . $like . '</span><i class="fa fa-heart"></i></button>
                    <a href="' . $this->url->get($value["LienLivre"]) . '" class="btn btn-primary embed ' . $value["IdPub"] . '" id="embed' . $value["IdPub"] . '"> <i class="fa fa-book"></i> lire</a>
                      <button type="button" class="btn btn-warning likeby ' . $value["IdPub"] . '" data-toggle="collapse" data-target="#likeby">like by</button>   
                    <a href="#" class="btn btn-default comment" id="' . $value["IdPub"] . '"  data-toggle="modal" data-target="#example" > <i class="fa fa-comment"></i></a>

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
            <br/>
        </div>';
            }
            $output .= ' </div>';


            $sql1 = "SELECT * from publication ORDER BY Vues DESC limit 1,3";
            $req1 = $conec->fetchAll($sql1, \Phalcon\Db::FETCH_ASSOC);
            $this->view->vues = $req1;
            // die(var_dump($perpageresult));
            $this->view->pub = $output;
        } else {
            $this->flashSession->error("Echec d'authentification");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }
    }

    public function publoadAction() {
        $this->view->disable();
        $config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'brainblue',
        ];

        $conec = new Mysql($config);

        $perPage = 3;
        $limt = count($conec->fetchAll("SELECT * from publication", \Phalcon\Db::FETCH_ASSOC));


        $sql = "SELECT * from publication ORDER BY IdPub DESC";
        $paginationlink = $this->url->get("Default/pubload") . "?page=";
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
            $like = count($conec->fetchAll("SELECT * from liker WHERE IdPub=:IdPub", \Phalcon\Db::FETCH_ASSOC, [
                        "IdPub" => $value["IdPub"],
            ]));
            $output .= '<input type="hidden" id="rowcountpub" name="rowcount" value="' . $_GET["rowcount"] . '" />';
            $output .= '<input type="hidden" class="pagenumpub" value="' . $page . '" /><input type="hidden" class="total-pagepub" value="' . $pages . '" />';
            $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">' . $value["Titre"] . '</h4> 
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '">
                    <h7 class="text-muted"> <i class="fa fa-eye"></i><span class="' . $value["IdPub"] . '"> ' . $value["Vues"] . '</span> vues</h7>
                    <p class="card-text">' . $value["text"] . '</p>
                </div>
                <div class="card-footer">

                    <button type="button" class="btn btn-danger like ' . $value["IdPub"] . '" > <span class="like' . $value["IdPub"] . '"> ' . $like . '</span><i class="fa fa-heart"></i></button>
                    <a href="' . $this->url->get($value["LienLivre"]) . '" class="btn btn-primary embed ' . $value["IdPub"] . '" > <i class="fa fa-book"></i> lire</a>
                    <button type="button" class="btn btn-warning likeby ' . $value["IdPub"] . '" data-toggle="collapse" data-target="#likeby">like by</button>
                    <a href="#" class="btn btn-default comment" id="' . $value["IdPub"] . '"  data-toggle="modal" data-target="#example" > <i class="fa fa-comment"></i></a>

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> 
            </div>
            <br/>
        </div>';
        }



        //die(var_dump($output));
        // die(var_dump($perpageresult));
        echo $output;
    }

    public function likebyAction() {
        if ($this->session->has('IdUser')) {
            $this->view->disable();
            $output = '';
            if (isset($_GET["IdPub"])) {

                $req = Liker::find([
                            "(IdPub=:IdPub:)", "bind" => [
                                "IdPub" => $_GET["IdPub"],
                            ]
                ]);
                $id = $_GET["IdPub"];
                // die( var_dump($req));
                if ($req) {

                    foreach ($req as $value) {
                        $req1 = User::find([
                                    "(IdUser=:IdUser:)", "bind" => [
                                        "IdUser" => $value->getIdUser(),
                                    ]
                        ]);

                        foreach ($req1 as $value1) {
                            $output = '<p>' . $value1->getNom() . ' ' . $value1->getPrenom() . ' ' . date("r", $value->getDateLike()) . '</p>';
                        }
                    }
                } else {
                    // die(var_dump($req));

                    $output = 'Aucun Like';
                }
            }
            echo $output;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }
    }

    public function likeAction() {

        if ($this->session->has('IdUser')) {
            $this->view->disable();
            $output = '';
            if (isset($_GET["IdPub"])) {

                $req = Liker::findFirst([
                            "(IdPub=:IdPub:) AND IdUser = :IdUser:", "bind" => [
                                "IdPub" => $_GET["IdPub"],
                                "IdUser" => $this->session->get('IdUser'),
                            ]
                ]);
                $id = $_GET["IdPub"];
                // die( var_dump($req));
                if (!$req) {

                    $like = new Liker();
                    $like->DateLike = time();
                    $like->IdPub = $id;
                    $like->IdUser = $this->session->get('IdUser');

                    $var = $like->save();
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
                $compte = count($conec->fetchAll("SELECT * from liker WHERE IdPub=:IdPub", \Phalcon\Db::FETCH_ASSOC, [
                            "IdPub" => $id,
                ]));
                $output = $compte;
            }
            echo $output;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }
    }

    public function inscriptionAction() {
        if ($this->request->isPost()) {

            $option = $this->request->getPost("option");
            //die(var_dump($nom));

            $email = $this->request->getPost("email");
            $dateNaissance = $this->request->getPost("DateNaiss");
            $password = sha1($this->request->getPost("password"));
            $cpassword = sha1($this->request->getPost("cpassword"));
            $nom = $this->request->getPost("nom");
            $prenom = $this->request->getPost("prenom");
            //echo $id_fil;

            if ($option == "Lecteur") {
                $req = User::findFirst([
                            "Mail = :mail:", "bind" => [
                                "mail" => $email,
                            ]
                ]);
                if (($req == NULL)) {

                    if ($password == $cpassword) {
                        //die( var_dump(strtotime($dateNaissance)));
                        // die(var_dump($cpassword));

                        $lecteur = new User();
                        $lecteur->Mail = $email;
                        $lecteur->Nom = $nom;
                        $lecteur->Prenom = $prenom;
                        $lecteur->DateNaiss = strtotime($dateNaissance);
                        $lecteur->Password = $password;
                        $var = $lecteur->save();
                        //die(var_dump($var));


                        if ($var) {

                            $this->flashSession->success("Enregistrement effectue avec sucess");
                            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                        } else {
                            $this->flashSession->error("Echec d'enregistrement");
                            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                        }
                    } else {
                        $this->flashSession->error("Password non correct");
                        return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                    }
                } else {
                    $this->flashSession->error("Mail deja utilisé");
                    return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                }
            } else {
                $req = User::findFirst([
                            "Mail = :mail:", "bind" => [
                                "mail" => $email,
                            ]
                ]);

                if (($req == NULL)) {

                    if ($password == $cpassword) {
                        //die( var_dump(strtotime($dateNaissance)));
                        // die(var_dump($cpassword));
                        $auteur = new User();

                        $auteur->Mail = $email;
                        $auteur->Nom = $nom;
                        $auteur->Prenom = $prenom;
                        $auteur->DateNaiss = strtotime($dateNaissance);
                        $auteur->Password = $password;
                        $var = $auteur->save();
                        //die(var_dump($var));


                        if ($var) {

                            $auteur1 = new Auteur();
                            $auteur1->IdUser = $auteur->IdUser;
                            $var = $auteur->save();
                            if ($var) {

                                $this->flashSession->success("Enregistrement effectue avec sucess");
                                return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                            } else {
                                $this->flashSession->error("Echec d'enregistrement");
                                return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                            }

                            $this->flashSession->success("Enregistrement effectue avec sucess");
                            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                        } else {
                            $this->flashSession->error("Echec d'enregistrement");
                            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                        }
                    } else {
                        $this->flashSession->error("Password non correct");
                        return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                    }
                } else {
                    $this->flashSession->error("Mail deja utilisé");
                    return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                }
            }
        }
    }

    public function controlpassAction() {

        $this->view->disable();



        $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\ \]\|;:"\<\>,\.\?\\\]/';
        $pattern3 = '/^[0-9]/';


        if (isset($_GET['pass'])) {
            $pseud = $_GET['pass'];
            $data = '';
            //die(var_dump(($pseud)));
            if (preg_match($pattern, $pseud) == 1 && preg_match($pattern3, $pseud) == 1) {
                $data .= '<div style="color:greenyellow;">Fort</div> <script>  document.getElementById("but").disabled = 0;   </script> ';
            } else if (preg_match($pattern, $pseud) == 0 && preg_match($pattern3, $pseud) == 1) {
                $data .= '<div style="color:greenyellow;">Fort</div> <script>  document.getElementById("but").disabled = 0;   </script> ';
            } else if (preg_match($pattern, $pseud) == 1 && preg_match($pattern3, $pseud) == 0) {
                $data .= '<div style="color:greenyellow;">Fort</div> <script>  document.getElementById("but").disabled = 0;   </script> ';
            } else if (preg_match($pattern, $pseud) == 0 && preg_match($pattern3, $pseud) == 0) {
                $data .= '<div style="color:orange;">Moyen</div> <script>  document.getElementById("but").disabled = 0;   </script> ';
            } else {
                $data .= '<div style="color:orange;">Moyen</div> <script>  document.getElementById("but").disabled = 0;   </script> ';
            }
        } else {
            $data = '<div style="color:orange;"> Vide </div> <script> document.getElementById("but").disabled = -1;  </script> ';
        }

        if (isset($_GET['pass']) && isset($_GET['confirm'])) {
            $pass = $_GET['pass'];
            $confirm = $_GET['confirm'];
            $data = '';
            if ($pass != $confirm) {
                $data .= '<div style="color:greenyellow;">veuillez confirmer correctement votre mot de pass</div> <script>  document.getElementById("but").disabled = -1;   </script> ';
            } else {
                $data .= ' <script>  document.getElementById("but").disabled = 0;   </script> ';
            }
        } else {
            $data = '<div style="color:orange;"> Champ de confirmation vide </div> <script> document.getElementById("but").disabled = -1;  </script> ';
        }



        echo $data;
    }

    public function connexionAction() {
        if ($this->request->isPost()) {

            $email = $this->request->getPost("email");
            $password = sha1($this->request->getPost("password"));
            $option = $this->request->getPost("option");
            if ($option == "Lecteur") {
                $req = User::findFirst([
                            "(Mail=:email:) AND Password = :password:", "bind" => [
                                "email" => $email,
                                "password" => $password,
                            ]
                ]);
                // die( var_dump($req));
                if ($req) {

                    $this->session->set('IdUser', $req->getIdUser());

                    $this->flashSession->error("Authentification Réussit");
                    //die(var_dump($_SESSION['id']));
                    return $this->response->redirect($this->url->getBaseUri() . "user/index", true);
                } else {
                    $this->flashSession->error("Echec d'authentification");
                    return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                }
            } elseif ($option == "Auteur") {
                $req = User::findFirst([
                            "(Mail=:email:) AND Password = :password:", "bind" => [
                                "email" => $email,
                                "password" => $password,
                            ]
                ]);
                // die( var_dump($req));
                if ($req) {

                    $this->session->set('IdUser', $req->getIdUser());
                    $req1 = Auteur::findFirst([
                                "IdUser=:IdUser:", "bind" => [
                                    "IdUser" => $req->getIdUser(),
                                ]
                    ]);
                    if (req1) {
                        $this->session->set('IdAut', $req1->getIdAut());
                        $this->flashSession->error("Authentification Réussit");
                        return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                    } else {
                        $this->flashSession->error("Echec d'authentification");
                        return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                    }

                    //die(var_dump($_SESSION['id']));
                } else {
                    $this->flashSession->error("Echec d'authentification");
                    return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                }
            }
// The validation has failed
        }
    }

    public function deconnexionAction() {
        if ($this->request->isPost()) {
            if ($this->session->has('IdAut') && $this->session->has('IdUser')) {
                $this->session->remove('IdAut');
                $this->session->remove('IdUser');
                $this->session->destroy();
                return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
            } elseif ($this->session->has('IdUser')) {
                $this->session->remove('IdUser');
                $this->session->destroy();
                return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
            }
            // die( var_dump($_SESSION['id']));
// Close session
// 
// ...
// A HTTP Redirect
        }
    }

    public function searchpubAction() {

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
            $req = $conec->fetchAll("SELECT * FROM publication WHERE titre LIKE :titre", \Phalcon\Db::FETCH_ASSOC, [
                "titre" => "%" . $titre . "%"
            ]);
//die(var_dump($req));
            if ($req != NULL) {
                $output = '';
                $output .= '<div class="row">';
                foreach ($req as $value) {
                    $like = count($conec->fetchAll("SELECT * from liker WHERE IdPub=:IdPub", \Phalcon\Db::FETCH_ASSOC, [
                        "IdPub" => $value["IdPub"],
            ]));
            
            $output .= '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">' . $value["Titre"] . '</h4> 
                    <img height="120px" src="' . $this->url->get($value["cover"]) . '">
                    <h7 class="text-muted"> <i class="fa fa-eye"></i><span class="' . $value["IdPub"] . '"> ' . $value["Vues"] . '</span> vues</h7>
                    <p class="card-text">' . $value["text"] . '</p>
                </div>
                <div class="card-footer">

                    <button type="button" class="btn btn-danger like ' . $value["IdPub"] . '" > <span class="like' . $value["IdPub"] . '"> ' . $like . '</span><i class="fa fa-heart"></i></button>
                    <a href="' . $this->url->get($value["LienLivre"]) . '" class="btn btn-primary embed ' . $value["IdPub"] . '" > <i class="fa fa-book"></i> lire</a>
                    <button type="button" class="btn btn-warning likeby ' . $value["IdPub"] . '" data-toggle="collapse" data-target="#likeby">like by</button>
                    <a href="#" class="btn btn-default comment" id="' . $value["IdPub"] . '"  data-toggle="modal" data-target="#example" > <i class="fa fa-comment"></i></a>

                </div>
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small> 
            </div>
            <br/>
        </div>';
                }
                $output.="</div>";
// die(var_dump($data));

                echo $output;
            } else {
                echo '<h7 class = "col-md-12 text-muted text-center" style = "color:black; "> Aucun résultat </h7></div>';
            }
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));
        }
    }

}
