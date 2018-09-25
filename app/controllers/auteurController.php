<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Adapter\Pdo\Mysql;
class auteurController extends Controller {

    public function indexAction() {

        if ($this->session->has('IdUser') && $this->session->has('IdAut')) {

            $req = Auteur::findByIdUser($this->session->get('IdUser'));
            $req1 = User::findByIdUser($this->session->get('IdUser'));
            $this->view->auteur = $req;
            $this->view->user = $req1;
           

            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];

            $conec = new Mysql($config);

            $perPage = 3;
            $limt = count($conec->fetchAll("SELECT * from publication where IdAut=:IdAut", \Phalcon\Db::FETCH_ASSOC, [
                            "IdAut" => $this->session->get('IdAut'),
                ]));



            $sql = "SELECT * from publication where IdAut=:IdAut ORDER BY IdPub DESC";
            $paginationlink = $this->url->get("auteur/pubload") . "?page=";
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
                            "IdAut" => $this->session->get('IdAut'),
                ]);
            //die(var_dump($req));


            if (empty($_GET["rowcount"])) {
                $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                            "IdAut" => $this->session->get('IdAut'),
                ]));
            }
            $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, [
                            "IdAut" => $this->session->get('IdAut'),
                ]));
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
            $this->flashSession->error("Authentifiez vous");
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
            $limt = count($conec->fetchAll("SELECT * from publication where IdAut=:IdAut", \Phalcon\Db::FETCH_ASSOC, [
                            "IdAut" => $this->session->get('IdAut'),
                ]));



            $sql = "SELECT * from publication where IdAut=:IdAut ORDER BY IdPub DESC";
            $paginationlink = $this->url->get("auteur/pubload") . "?page=";
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
                            "IdAut" => $this->session->get('IdAut'),
                ]);
            //die(var_dump($req));


            if (empty($_GET["rowcount"])) {
                $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                            "IdAut" => $this->session->get('IdAut'),
                ]));
            }
            $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, [
                            "IdAut" => $this->session->get('IdAut'),
                ]));
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

    public function profilAction() {
        if ($this->session->has('IdUser') && $this->session->has('IdAut')) {
            if ($this->request->hasFiles()) {
                $files = $this->request->getUploadedFiles();

// Print the real file names and sizes
                foreach ($files as $file) {
                    if (!$file->isUploadedFile()) {
                        $this->flashSession->error("Le fichier est introuvable");
                        return $this->response->redirect($this->url->getBaseUri() . "proposition/index", true);
                    }
                    $temp_name = $file->getTempName();
                    $type = $file->getExtension();
                    $chaine = md5(uniqid(rand(), true));
                    $name_file = "{" . $chaine . "}" . "." . "{$type}";
                    if (!strstr($type, 'jpg') && !strstr($type, 'jpeg') && !strstr($type, 'bmp') && !strstr($type, 'gif') && !strstr($type, 'png')) {

                        $this->flashSession->error("Le fichier n'est pas  une image");
                        return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                    } elseif (!move_uploaded_file($temp_name, $this->ProfilAuteur . $name_file)) {
                        $this->flashSession->error("Impossible de copier le fichier dans" . $this->ProfilAuteur);
                        return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                    } else {
                        $profil = "/public/ProfilAuteur/" . $name_file;
                    }
                }
            }
            if (isset($profil)) {
                $auteur = Auteur::findByIdUser($this->session->get('IdUser'));
                $auteur->update(['profil' => $profil]);
                if ($auteur) {

                    $this->flashSession->success("Modification effectue avec sucess");
                    return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                } else {
                    $this->flashSession->error("Echec de modification");
                    return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                }
            }
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }
    }

    public function modifierAction() {

        if ($this->session->has('IdUser') && $this->session->has('IdAut')) {

            $req = Auteur::findByIdUser($this->session->get('IdUser'));
            $req1 = User::findByIdUser($this->session->get('IdUser'));
            $this->view->auteur = $req;
            $this->view->user = $req1;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }

        if ($this->request->isPost()) {

            $bibio = $this->request->getPost("bibiographie");
//die(var_dump($nom));

            $email = $this->request->getPost("email");
            $dateNaissance = strtotime($this->request->getPost("DateNaiss"));
            $password = sha1($this->request->getPost("password"));
            $cpassword = sha1($this->request->getPost("cpassword"));
            $nom = $this->request->getPost("nom");
            $prenom = $this->request->getPost("prenom");

//echo $id_fil;


            if ($password == $cpassword) {
//die( var_dump(strtotime($dateNaissance)));
// die(var_dump($cpassword));
                $req = Auteur::findByIdUser($this->session->get('IdUser'));
                $req1 = User::findByIdUser($this->session->get('IdUser'));

                $req1->update(['Nom' => $nom, 'Prenom' => $prenom, 'Password' => $password, 'DateNaiss' => $dateNaissance, 'Mail' => $email]);
                $req->update(['bibiographie' => $bibio]);




                if ($req && $req1) {
                    //Sdie(var_dump($req1));
                    $this->flashSession->success("Modification effectue avec sucess");
                    return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                } else {
                    $this->flashSession->error("Echec de modification");
                    return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                }
            } else {
                $this->flashSession->error("Password non correct");
                return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
            }
        }
    }

}
