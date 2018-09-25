<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Adapter\Pdo\Mysql;

class adminController extends Controller {

    public function indexAction() {
        if ($this->request->isPost()) {

            $pseudo = $this->request->getPost("pseudo");
            $password = sha1($this->request->getPost("password"));

            $req = Admin::findFirst([
                        "(pseudoadmin=:pseudo:) AND Passwordadmin = :password:", "bind" => [
                            "pseudo" => $pseudo,
                            "password" => $password,
                        ]
            ]);
            // die( var_dump($req));
            if ($req) {

                $this->session->set('IdAdmin', $req->getIdAdmin());

                $this->flashSession->error("Authentification Réussit");
                //die(var_dump($_SESSION['id']));
                return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
            } else {
                $this->flashSession->error("Echec d'authentification");
                return $this->response->redirect($this->url->getBaseUri() . "admin/index", true);
            }
        }
// The validation has failed
    }

    public function principalAction() {
        if ($this->session->has('IdAdmin')) {

            $req = Categorie::find();
            $this->view->categories = $req;



            if ($this->request->isPost()) {

                $titre = $this->request->getPost("titre");
                $auteur = $this->request->getPost("auteur");
                $description = $this->request->getPost("description");
                $cat = $this->request->getPost("categorie");
                if ($this->request->hasFiles()) {
                    $files = $this->request->getUploadedFiles();

                    // Print the real file names and sizes
                    foreach ($files as $file) {
                        if (!$file->isUploadedFile()) {
                            $this->flashSession->error("Le fichier est introuvable");
                            return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                        }
                        $temp_name = $file->getTempName();
                        $type = $file->getExtension();
                        $chaine = md5(uniqid(rand(), true));
                        $name_file = "{" . $chaine . "}" . "." . "{$type}";
                        if (!strstr($type, 'jpg') && !strstr($type, 'jpeg') && !strstr($type, 'bmp') && !strstr($type, 'gif') && !strstr($type, 'png')) {
                            if (!strstr($type, 'docx') && !strstr($type, 'txt') && !strstr($type, 'pdf') && !strstr($type, 'pages') && !strstr($type, 'doc')) {

                                $this->flashSession->error("Le fichier n'est pas un Livre");
                                return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                            } elseif (!move_uploaded_file($temp_name, $this->LivreDoc . $name_file)) {
                                $this->flashSession->error("Impossible de copier le fichier dans $content_dir");
                                return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                            } else {
                                $lien = "/public/LivreDoc/" . $name_file;
                            }
                            if (!isset($lien)) {
                                $this->flashSession->error("Le fichier n'est pas  une image");
                                return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                            }
                        } elseif (!move_uploaded_file($temp_name, $this->LivreCover . $name_file)) {
                            $this->flashSession->error("Impossible de copier le fichier dans $content_dir");
                            return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                        } else {
                            $cover = "/public/LivreCover/" . $name_file;
                        }
                    }
                }



                // Move the file into the application
                //die(var_dump($id));
                $livre = new Livre();
                $livre->auteur = $auteur;
                $livre->titre = $titre;
                $livre->IdCat = $cat;
                $livre->description = $description;
                if (isset($cover)) {
                    $livre->cover = $cover;
                }
                if (isset($lien)) {
                    $livre->lien = $lien;
                }
                $var = $livre->save();

                if ($var) {

                    $this->flashSession->success("Livre ajouté avec sucess");
                    return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                } else {
                    $this->flashSession->error("Echec d'ajout du livre");
                    return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                }
            }
        } else {
            $this->flashSession->error("Echec d'authentification");
            return $this->response->redirect($this->url->getBaseUri() . "admin/index", true);
        }
    }

    public function deconnexionAction() {
        if ($this->request->isPost()) {
            if ($this->session->has('IdAdmin')) {
                $this->session->remove('IdAdmin');
                $this->session->destroy();
                return $this->response->redirect($this->url->getBaseUri() . "admin/index", true);
            }
            // die( var_dump($_SESSION['id']));
// Close session
// 
// ...
// A HTTP Redirect
        }
    }

    public function propositionloadAction() {

        $this->view->disable();

        $config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'brainblue',
        ];

        $conec = new Mysql($config);

        $perPage = 1;
        $limt = count($conec->fetchAll("SELECT * from proposition", \Phalcon\Db::FETCH_ASSOC));


        $sql = "SELECT * from proposition ORDER BY IdPro DESC";
        $paginationlink = $this->url->get("admin/propositionload") . "?page=";
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

        // die(var_dump($query));
        $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC);
        //die(var_dump($req));


        if (empty($_GET["rowcountpro"])) {
            $_GET["rowcountpro"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC));
        }
        $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC));
        $pages = ceil($test / $perPage);


        // die(var_dump($req));
        // die(var_dump($query));
        $output = '';
        foreach ($req as $value) {

            $req1 = Livre::findFirst([
                        "IdLi = :IdLi:", "bind" => [
                            "IdLi" => $value["IdLi"],
                        ]
            ]);
            $req2 = User::findFirst([
                        "IdUser = :IdUser:", "bind" => [
                            "IdUser" => $value["IdUser"],
                        ]
            ]);





            $output .= '<tr id="' . $value["IdPro"] . '">
                            <td>' . $value["IdPro"] . '  </td>
                            <td>' . $req1->getTitre() . '</td>
                            <td>' . $req1->getAuteur() . '</td>
                            <td>' . $req2->getNom() . " " . $req2->getPrenom() . '</td>
                            <td>' . strftime("%x", $value["DatePro"]) . '</td>
                            <td>';
            if ($value["Status"] == NULL) {
                $output .= '<button type="submit"  class="btn btn-danger btn-sm rejectpro" value="' . $value["IdPro"] . '"> <i class="fa fa-remove fa-1x"></i></button> 
                                <button type="submit" class="btn btn-success btn-sm acceptpro" value="' . $value["IdPro"] . '"><i class="fa fa-check fa-1x"></i></button>
                            </td>';
            } else {
                $output .= '' . $value["Status"] . '</td>';
            }
            $output .= '<input type="hidden" id="rowcountpro" name="rowcountpro" value="' . $_GET["rowcountpro"] . '" />';
            $output .= '<input type="hidden" class="pagenumpro" value="' . $page . '" /><input type="hidden" class="total-pagepro" value="' . $pages . '" />';

            $output .= '</tr>';
        }


        // die(var_dump($perpageresult));
        echo $output;
    }

    public function rejectproAction() {

        $this->view->disable();
        $id = $_GET["IdPro"];

        $req = Proposition::findFirst([
                    "IdPro = :id:", "bind" => [
                        "id" => $id,
                    ]
        ]);
        if ($req != NULL) {

            $req->update(['Status' => "NO"]);
            echo $req->Status;
        }
    }

    public function acceptproAction() {

        $this->view->disable();
        $id = $_GET["IdPro"];

        $req = Proposition::findFirst([
                    "IdPro = :id:", "bind" => [
                        "id" => $id,
                    ]
        ]);
        if ($req != NULL) {

            $req->update(['Status' => "YES"]);
            echo $req->Status;
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

        $perPage = 1;
        $limt = count($conec->fetchAll("SELECT * from livre", \Phalcon\Db::FETCH_ASSOC));


        $sql = "SELECT * from livre ORDER BY IdLi DESC";
        $paginationlink = $this->url->get("admin/livreload") . "?page=";
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

        // die(var_dump($query));
        $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC);
        //die(var_dump($req));


        if (empty($_GET["rowcountli"])) {
            $_GET["rowcountli"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC));
        }
        $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC));
        $pages = ceil($test / $perPage);


        // die(var_dump($req));
        // die(var_dump($query));
        $output = '';
        foreach ($req as $value) {



            $output .= '<tr id="' . $value["IdLi"] . '">
                            <td>' . $value["IdLi"] . '</td>
                            <td><a href="' . $this->url->get($value["lien"]) . '">' . $value["titre"] . '</a></td>
                              <td>  <img height="120px" src="' . $this->url->get($value["cover"]) . '"></td>
                            <td>' . $value["auteur"] . '</td>
                            <td>' . $value["description"] . '</td>
                            <td>      
                                <button type="submit" class="btn btn-danger btn-sm supress" value="' . $value["IdLi"] . '"> <i class="fa fa-remove fa-1x"></i></button>                                 
                                <button type="submit" class="btn btn-primary btn-sm update" value="' . $value["IdLi"] . '" data-toggle="collapse" data-target="#update"><i class="fa fa-pencil fa-1x"></i></button>
                            </td>

                        </tr>';

            $output .= '<input type="hidden" id="rowcountli" name="rowcountli" value="' . $_GET["rowcountli"] . '" />';
            $output .= '<input type="hidden" class="pagenumli" value="' . $page . '" /><input type="hidden" class="total-pageli" value="' . $pages . '" />';
        }


        // die(var_dump($perpageresult));
        echo $output;
    }

    public function supressAction() {

        $this->view->disable();
        $id = $_GET["IdLi"];

        $req = Livre::findFirst([
                    "IdLi = :id:", "bind" => [
                        "id" => $id,
                    ]
        ]);
        $req1 = Proposition::findFirst([
                    "IdLi = :id:", "bind" => [
                        "id" => $id,
                    ]
        ]);
        if ($req != NULL) {
            if ($req1 != NULL) {
                $req1->delete();
            }
            $req->delete();
            echo "supress";
        }
    }

    public function updatesearchAction() {

        $this->view->disable();
        $id = $_GET["IdLi"];

        $req = Livre::findFirst([
                    "IdLi = :id:", "bind" => [
                        "id" => $id,
                    ]
        ]);
        $output = '';
        if ($req != NULL) {

            $output .= '<input type="text" size="25" class="form-control" name="titre" value="' . $req->getTitre() . '" placeholder="Titre du livre..." required>
                <br/>

                <textarea type="text" size="200" class="form-control" name="description"  required>' . $req->getDescription() . '</textarea>
                <br/>

                <input type="text" size="25" class="form-control" name="auteur" value="' . $req->getAuteur() . '" placeholder="Auteur..." required>
                   <input type="hidden" name="IdLi" value="' . $id . '"> ';
        }

        echo $output;
    }

    public function updateAction() {
        if ($this->session->has('IdAdmin')) {
            if ($this->request->isPost()) {

                $titre = $this->request->getPost("titre");
                $auteur = $this->request->getPost("auteur");
                $description = $this->request->getPost("description");
                $cat = $this->request->getPost("categorie");
                $id = $this->request->getPost("IdLi");

                $req = Livre::findFirst([
                            "IdLi = :id:", "bind" => [
                                "id" => $id,
                            ]
                ]);
                if ($req != NULL) {
                    if ($this->request->hasFiles()) {
                        $files = $this->request->getUploadedFiles();

                        // Print the real file names and sizes
                        foreach ($files as $file) {
                            if (!$file->isUploadedFile()) {
                                $this->flashSession->error("Le fichier est introuvable");
                                return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                            }
                            $temp_name = $file->getTempName();
                            $type = $file->getExtension();
                            $chaine = md5(uniqid(rand(), true));
                            $name_file = "{" . $chaine . "}" . "." . "{$type}";
                            if (!strstr($type, 'jpg') && !strstr($type, 'jpeg') && !strstr($type, 'bmp') && !strstr($type, 'gif') && !strstr($type, 'png')) {
                                if (!strstr($type, 'docx') && !strstr($type, 'txt') && !strstr($type, 'pdf') && !strstr($type, 'pages') && !strstr($type, 'doc')) {

                                    $this->flashSession->error("Le fichier n'est pas un Livre");
                                    return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                                } elseif (!move_uploaded_file($temp_name, $this->LivreDoc . $name_file)) {
                                    $this->flashSession->error("Impossible de copier le fichier dans $content_dir");
                                    return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                                } else {
                                    $lien = "/public/LivreDoc/" . $name_file;
                                }
                                if (!isset($lien)) {
                                    $this->flashSession->error("Le fichier n'est pas  une image");
                                    return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                                }
                            } elseif (!move_uploaded_file($temp_name, $this->LivreCover . $name_file)) {
                                $this->flashSession->error("Impossible de copier le fichier dans $content_dir");
                                return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                            } else {
                                $cover = "/public/LivreCover/" . $name_file;
                            }
                        }
                    }


                    $req->update(['auteur' => $auteur, 'titre' => $titre, 'Idcat' => $cat, 'description' => $description]);
                    // Move the file into the application
                    //die(var_dump($id));

                    if (isset($cover)) {
                        $req->update(['cover' => $cover]);
                    }
                    if (isset($lien)) {
                        $req->update(['lien' => $lien]);
                    }



                    if ($req) {

                        $this->flashSession->success("Livre modifié avec sucess");
                        return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                    } else {
                        $this->flashSession->error("Echec de modification du livre");
                        return $this->response->redirect($this->url->getBaseUri() . "admin/principal", true);
                    }
                }
            }
        } else {
            $this->flashSession->error("Echec d'authentification");
            return $this->response->redirect($this->url->getBaseUri() . "admin/index", true);
        }
    }

    public function searchlivreAction() {

        $this->view->disable();
        if (isset($_GET['pourc']) && $this->session->has('IdAdmin')) {
            $config = [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'dbname' => 'brainblue',
            ];
            $titre = $_GET['pourc'];
            $conec = new Mysql($config);
            $req = $conec->fetchAll("SELECT * FROM livre WHERE titre LIKE :titre", \Phalcon\Db::FETCH_ASSOC, [
                "titre" => "%" . $titre . "%"
            ]);
//die(var_dump($req));
            if ($req != NULL) {
                $data = '';
                foreach ($req as $value) {
                    $data .= '<tr id="' . $value["IdLi"] . '">
                            <td>' . $value["IdLi"] . '</td>
                            <td><a href="' . $this->url->get($value["lien"]) . '">' . $value["titre"] . '</a></td>
                              <td>  <img height="120px" src="' . $this->url->get($value["cover"]) . '"></td>
                            <td>' . $value["auteur"] . '</td>
                            <td>' . $value["description"] . '</td>
                            <td>      
                                <button type="submit" class="btn btn-danger btn-sm supress" value="' . $value["IdLi"] . '"> <i class="fa fa-remove fa-1x"></i></button>                                 
                                <button type="submit" class="btn btn-primary btn-sm update" value="' . $value["IdLi"] . '" data-toggle="collapse" data-target="#update"><i class="fa fa-pencil fa-1x"></i></button>
                            </td>

                        </tr>';
                }
// die(var_dump($data));

                echo $data;
            } else {
                echo '<h7 class = "col-md-12 text-muted text-center" style = "color:black; "> Aucun résultat </h7></div>';
            }
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));
        }
    }

}
