<?php

use Phalcon\Mvc\Controller;

class propositionController extends Controller {

    public function indexAction() {
        if ($this->session->has('IdUser')) {

            $req = Categorie::find();
            $this->view->categories = $req;
        } else {
            $this->flashSession->error("Authentifiez vous");
            return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
        }

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
                        return $this->response->redirect($this->url->getBaseUri() . "proposition/index", true);
                    }
                    $temp_name = $file->getTempName();
                    $type = $file->getExtension();
                    $chaine = md5(uniqid(rand(), true));
                    $name_file = "{" . $chaine . "}" . "." . "{$type}";
                    if (!strstr($type, 'jpg') && !strstr($type, 'jpeg') && !strstr($type, 'bmp') && !strstr($type, 'gif') && !strstr($type, 'png')) {
                        if (!strstr($type, 'docx') && !strstr($type, 'txt') && !strstr($type, 'pdf') && !strstr($type, 'pages') && !strstr($type, 'doc')) {

                            $this->flashSession->error("Le fichier n'est pas un Livre");
                            return $this->response->redirect($this->url->getBaseUri() . "proposition/index", true);
                        } elseif (!move_uploaded_file($temp_name, $this->PropositionDoc . $name_file)) {
                            $this->flashSession->error("Impossible de copier le fichier dans $content_dir");
                            return $this->response->redirect($this->url->getBaseUri() . "proposition/index", true);
                        } else {
                            $lien = "/public/PropositionDoc/" . $name_file;
                        }
                        if (!isset($lien)) {
                            $this->flashSession->error("Le fichier n'est pas  une image");
                            return $this->response->redirect($this->url->getBaseUri() . "proposition/index", true);
                        }
                    } elseif (!move_uploaded_file($temp_name, $this->PropositionCover . $name_file)) {
                        $this->flashSession->error("Impossible de copier le fichier dans $content_dir");
                        return $this->response->redirect($this->url->getBaseUri() . "proposition/index", true);
                    } else {
                        $cover = "/public/PropositionCover/" . $name_file;
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

                //die(var_dump($livre->IdLi));
               
                    $proposition = new Proposition();
                   $proposition->IdLi=$livre->IdLi;
                   $proposition->DatePro= time();
                   $proposition->IdUser=$this->session->get('IdUser');
                    $var = $proposition->save();
                    if ($var) {

                        $this->flashSession->success("Proposition effectue avec sucess");
                        return $this->response->redirect($this->url->getBaseUri() . "livre/bibliotheque", true);
                    } else {
                        $this->flashSession->error("Echec de proposition");
                        return $this->response->redirect($this->url->getBaseUri() . "proposition/index", true);
                    }
                
            }
        }
// The validation has failed
    }

}
