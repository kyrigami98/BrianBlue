<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Adapter\Pdo\Mysql;

class publicationController extends Controller {

    public function publierAction() {
        if ($this->session->has('IdUser') && $this->session->has('IdAut')) {
            if ($this->request->isPost()) {

                $titre = $this->request->getPost("titre");
                $text = $this->request->getPost("text");
                if ($this->request->hasFiles()) {
                    $files = $this->request->getUploadedFiles();

                    // Print the real file names and sizes
                    foreach ($files as $file) {
                        if (!$file->isUploadedFile()) {
                            $this->flashSession->error("Le fichier est introuvable");
                            return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                        }
                        $temp_name = $file->getTempName();
                        $type = $file->getExtension();
                        $chaine = md5(uniqid(rand(), true));
                        $name_file = "{" . $chaine . "}" . "." . "{$type}";
                        if (!strstr($type, 'jpg') && !strstr($type, 'jpeg') && !strstr($type, 'bmp') && !strstr($type, 'gif') && !strstr($type, 'png')) {
                            if (!strstr($type, 'docx') && !strstr($type, 'txt') && !strstr($type, 'pdf') && !strstr($type, 'pages') && !strstr($type, 'doc')) {

                                $this->flashSession->error("Le fichier n'est pas un Livre");
                                return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                            } elseif (!move_uploaded_file($temp_name, $this->PublicationDoc . $name_file)) {
                                $this->flashSession->error("Impossible de copier le fichier dans " . $this->PublicationDoc);
                                return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                            } else {
                                $lien = "/public/PublicationDoc/" . $name_file;
                            }
                            if (!isset($lien)) {
                                $this->flashSession->error("Le fichier n'est pas  une image");
                                return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                            }
                        } elseif (!move_uploaded_file($temp_name, $this->PublicationCover . $name_file)) {
                            $this->flashSession->error("Impossible de copier le fichier dans " . $this->PublicationCover);
                            return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                        } else {
                            $cover = "/public/PublicationCover/" . $name_file;
                        }
                    }
                }

                // Move the file into the application
                //die(var_dump($id));
                $pub = new Publication();
                $pub->DatePub = time();
                $pub->IdAut = $this->session->get('IdAut');
                $pub->Titre = $titre;
                $pub->text = $text;

                if (isset($cover)) {
                    $pub->cover = $cover;
                }
                if (isset($lien)) {
                    $pub->LienLivre = $lien;
                }
                //die(var_dump($lien));
                $var = $pub->save();


                //die(var_dump($livre->IdLi));
                if ($var) {

                    $this->flashSession->success("Publication effectue avec sucess");
                    return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                } else {
                    $this->flashSession->error("Echec de publication");
                    return $this->response->redirect($this->url->getBaseUri() . "auteur/index", true);
                }
            } else {
                $this->flashSession->error("Echec d'authentification");
                return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
            }
        }
    }

    public function addcommentAction() {

        if ($this->request->isPost() && $this->session->has('IdUser')) {
//die( var_dump(preg_match("/%/i", $this->request->getPost("pourc"))));

            $IdPub = $this->request->getPost("IdPub");
            $text = $this->request->getPost("text");

            $comment = new CommenterPub();
// die( var_dump($req));
            $comment->DateCom = time();
            $comment->IdPub = $IdPub;
            $comment->IdUser = $this->session->get('IdUser');
            $comment->text = $text;
//die( var_dump($pourc));
            $var = $comment->save();
            $req = User::findByIdUser($this->session->get('IdUser'));
            if ($var) {
                foreach ($req as $value) {


                    echo '<p style="" class="" id="">
                                <i class="fa fa-user" style="font-size:20px;" aria-hidden="true"></i>
                    <span class=""><b>' . $value["Nom"] . ' ' . $value["Prenom"] . '</b></span>
                            <p class=" text-center">' . $comment->text . '</p><span class="pull-right">' . date("r", $comment->DateCom) . '</span>  <hr/>
                            </p>';
                }
            } else {
                echo 'Commentaire non eenrégistré';
            }
        }
    }

    public function messageloadAction() {

        $this->view->disable();

        $id = $_GET["IdPub"];
        $config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'brainblue',
        ];

        $conec = new Mysql($config);

        $perPage = 3;
        $limt = count($conec->fetchAll("SELECT * from commenter_pub WHERE IdPub=:IdPub", \Phalcon\Db::FETCH_ASSOC, [
                    "IdPub" => $id,
        ]));


        $sql = "SELECT * from commenter_pub WHERE IdPub=:IdPub ORDER BY IdCom DESC";
        $paginationlink = $this->url->get("publication/messageload") . "?IdPub=" . $id . "?page=";
        $page = 1;
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
            // die(var_dump($_GET["page"]));
            //die(var_dump($_GET["IdPub"]));
        }

        $start = ($page - 1) * $perPage;
        if ($start < 0) {
            $start = 0;
        }



        $query = $sql . " limit " . $start . "," . $perPage;
        //die(var_dump($query));
        $req = $conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
            "IdPub" => $id,
        ]);
        //die(var_dump($id));


        if (empty($_GET["rowcount"])) {
            $_GET["rowcount"] = count($conec->fetchAll($query, \Phalcon\Db::FETCH_ASSOC, [
                        "IdPub" => $id,
            ]));
        }
        $test = count($conec->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, [
                    "IdPub" => $id,
        ]));
        $pages = ceil($test / $perPage);


        // die(var_dump($req));
        $req1 = User::findByIdUser($this->session->get('IdUser'));
        $output = '';


        foreach ($req as $value) {
            $output .= '<input type="hidden" id="rowcountmess" name="rowcount" value="' . $_GET["rowcount"] . '" />';
            $output .= '<input type="hidden" class="pagenummess" value="' . $page . '" /><input type="hidden" class="total-pagemess" value="' . $pages . '" />';
            foreach ($req1 as $value1) {
                $output .= '<p style="" class="" >
                                <i class="fa fa-user" style="font-size:20px;" aria-hidden="true"></i>
                                <span class=""><b>' . $value1->getNom() . ' ' . $value1->getPrenom() . '</b></span>
                            <p class=" text-center">' . $value["text"] . '</p><span class="pull-right">' . date("r", $value["DateCom"]) . '</span>  <hr/>
                            </p>';
            }
        }



        //die(var_dump($output));
        // die(var_dump($perpageresult));
        echo $output;
    }

    public function vueAction() {
        $this->view->disable();
        $id = $_GET["IdPub"];

        $req = Publication::findFirst([
                    "IdPub = :id:", "bind" => [
                        "id" => $id,
                    ]
        ]);
        if ($req != NULL) {
                $i=(int)$req->Vues;
                $i++;
                $req->update(['Vues' => $i]);
                echo $req->Vues;
            
        }
    }

}
