<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>BrainBlue</title>
        <link rel="stylesheet" href="<?= $this->url->getBaseUri();?>public/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= $this->url->getBaseUri();?>public/css/user.css">
        <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link href="<?= $this->url->getBaseUri();?>public/vendor/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?= $this->url->getBaseUri();?>public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="<?= $this->url->getBaseUri();?>public/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="<?= $this->url->getBaseUri();?>public/js/ie-emulation-modes-warning.js"></script>
        <script type="text/javascript" src="<?= $this->url->getBaseUri();?>public/js/jquery.min.js"></script>

    </head>
    <body class="">

        <header style="height:300px;background-image:url('<?= $this->url->getBaseUri();?>public/img/bg.jpg');background-size:cover;">
            <nav class="navbar navbar-fixed-top img-raised" style="background-color:#428bca;">
                <div class="container">
                    <div class="navbar-header"><a class="navbar-brand navbar-link" href="#"><span class="text-title"><img height="60px" src="<?= $this->url->getBaseUri();?>public/img/elevate.png">Brain Blue</span></a>
                        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                    </div>
                    <div class="collapse navbar-collapse" id="navcol-1">


                <?php if (!$this->session->has('IdUser') && !$this->session->has('IdAdmin')){ ?>

                        <form action="<?= $this->url->get("default/connexion"); ?>" method="post">  
                            <ul class="nav navbar-nav navbar-right">
                                <li class="active" role="presentation"><input type="email" name="email" size="25" class="form-control" style="color:white;" placeholder="Mail..." required></li>
                                <li role="presentation"><input type="password" name="password" size="25" class="form-control" style="color:white;" placeholder="Mot de passe..." required></li>
                                <li role="presentation">    
                                    <select name="option" class="form-control">
                                        <option selected>Lecteur</option>
                                        <option>Auteur</option>
                                    </select>
                                </li>
                                <li role="presentation"><input type="submit" class="btn btn-success" value="connexion" style="color:white;"></li>

                                <li role="presentation" style="color:white;">OU</li>                      
                                <li role="presentation">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        S'inscrire</button>                
                                    <span class=""  id="ici" style="text-align:center;color:white;position:absolute; margin-top:40px">
                                        <i style="" class="fa fa-2x fa-arrow-up"></i><br/>inscrivez-vous pour avoir accès à d'autres fonctionnalités!
                                    </span>      
                                </li>
                                </div>
                            </ul>  
                        </form>
                   <?php }elseif (!$this->session->has('IdAdmin')) { ?>
                        <form action="<?= $this->url->get("default/deconnexion"); ?>" method="post">
                            <ul class="nav navbar-nav navbar-right">

                                <li class=""><a style="color:white;" href="<?= $this->url->get("livre/bibliotheque"); ?>"><i class="fa fa-2x fa-book"></i> Bibliothèque</a></li>
                                <li class=""><a style="color:white;" href="<?= $this->url->get("default/index"); ?>"><i class="fa fa-2x fa-coffee"></i> Espace Auteurs</a></li>
                                <li><a style="color:white;" href="<?= $this->url->get("proposition/index"); ?>"><i class="fa fa-2x fa-pencil-square"></i> Répertorier un livre</a></li>

                                <li class="nav-item dropdown">
                                    <a href="#" style="color:white;" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown">
                                        <i class="fa fa-user" style="font-size:20px;" aria-hidden="true"></i>
                                        <span class="">You</span> 
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <?php if ($this->session->has('IdAut') && $this->session->has('IdUser')) { ?>
                                        <a href="<?= $this->url->get("auteur/index"); ?>" class="dropdown-header"><img height="30px"  style="border-radius:10px 10px 10px 10px; " src="<?= $this->url->getBaseUri(); ?>public/img/book1.png" > Profil </a>
                            <?php }elseif($this->session->has('IdUser')){ ?>
                                        <a href="<?= $this->url->get("user/index"); ?>" class="dropdown-header"><img height="30px"  style="border-radius:10px 10px 10px 10px; " src="<?= $this->url->getBaseUri(); ?>public/img/book1.png" > Profil </a>
                            <?php } ?>
                                        <div class="divider"></div>
                                        <a href="<?= $this->url->get("user/favoris"); ?>" class="dropdown-header" ><i class="fa fa-star"></i> Mes favoris </a>
                                        <div class="divider"></div>
                                        <div class="divider"></div>
                                        <a href="<?= $this->url->get("user/index"); ?>" class="dropdown-header" ><i class="fa fa-star"></i> Mes Emprunts </a>
                                        <div class="divider"></div>
                                        <button class="dropdown-item btn btn-lg btn-primary" style="" type="submit">Déconnexion</button>

                                    </div>
                                </li> 
                            </ul>  
                        </form> 
                    <?php }elseif ($this->session->has('IdAdmin')) {?>
                        <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item dropdown">
                             <form action="<?= $this->url->get("admin/deconnexion"); ?>" method="post">
                            <button class="dropdown-item btn btn-lg btn-primary" style="" type="submit">Déconnexion</button>
                             </form>

                        </li> 
                        </ul>
                    <?php } ?>
                    </div>

                </div>
                </div>
            </nav>

            <!-- Carousel
             ================================================== -->
            <div id="myCarousel" class="carousel slide" data-ride="carousel" style="background:rgba(5, 5, 5, 0.5) ;">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img class="first-slide" src="" style="height:300px;" alt="First slide">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>Brain Blue vous accompagne.</h1>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img class="second-slide" src="" style="height:300px;" alt="Second slide">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>Apprenez, découvez, et publiez.</h1>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img class="third-slide" src="" style="height:300px;" alt="Third slide">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>Let's begin!</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div><!-- /.carousel -->


        </header>
        <br/>

        <div class="container">

            {{ content() }}

        </div> 


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Créer un compte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <form  action="<?= $this->url->get("default/inscription"); ?>" method="post" >
                        <div class="modal-body">

                            <input type="email" size="25" class="form-control" name="email" placeholder="Votre email..." required>
                            <br/>
                            <input type="text" size="25" class="form-control" name="nom" placeholder="Nom..." required>
                            <br/>
                            <input type="text" size="25" class="form-control" name="prenom" placeholder="Prénom..." required>
                            <br/>
                            <input type="date" size="25" class="form-control" name="DateNaiss" placeholder="Date de naissance..." required>
                            <br/> 
                            <br/>
                            <input type="password" id="pass" size="25" class="form-control" name="password" placeholder="Mot de passe..." required>
                            <br/>
                            <br/>
                            <input type="password"  id="confirm" size="25" class="form-control" name="cpassword" placeholder="Confirmer mot de passe..." required>
                            <br/>
                            <select name="option" class="form-control">
                                <option selected>Lecteur</option>
                                <option>Auteur</option>
                            </select>
                            <p class="" style="" id="passw"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="but">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="example" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="font-size:15px;" id="modalmess">
                    <div class="modal-header">
                        <h5 class="modal-title text-center">Commentaires</h5>

                    </div> 

                    <div class="modal-body" id="mess" >

                    </div>  
                    <p id="message"></p>
                    <p id="loadmessage"></p>
                    <button type="button" id="messload" value="" class="btn btn-info"><i class="fa fa-1x fa-eye"></i> Voir plus</button>

                    <form  action="#" method="post" id="formulaire" >
                        <div class="modal-footer">
                            <input type="text" size="25" class="form-control" name="text" placeholder="Laisser un commentaire..." required>
                            <span id="hidden"></span>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="ok">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <br/>  <br/>  <hr/> 
        <footer style="background-color:white; color:black;"><h5>Brain Blue © 2018</h5></footer>


        <script src="<?= $this->url->getBaseUri();?>public/js/jquery.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="<?= $this->url->getBaseUri();?>public/js/bootstrap.min.js"></script>
        <script src="<?= $this->url->getBaseUri();?>public/js/bootstrap.js"></script>
        <script src="<?= $this->url->getBaseUri();?>public/js/popper.js"></script>
        <script src="<?= $this->url->getBaseUri();?>public/js/carousel.js"></script>
        <script src="<?= $this->url->getBaseUri();?>public/js/popper.min.js"></script>
        <script src="<?= $this->url->getBaseUri();?>public/js/holder.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="<?= $this->url->getBaseUri();?>public/js/ie10-viewport-bug-workaround.js"></script>
        <script type="text/javascript" src="<?= $this->url->getBaseUri();?>public/js/jquery.gdocsviewer.min.js"></script>
        <script>
$(function () {


    $("#ici").ready(function () {
        function realtime() {

            $("#ici").animate({top: '-3px'}, 900);
            $("#ici").animate({top: '4px'}, 700);
            $("#ici").animate({top: '-3px'}, 700);
            $("#ici").animate({top: '4px'}, 700);


        }
        setInterval(realtime, 10);
    });

    


    $("#pass").keyup(function () {


        if ($("#pass").val().length >= 8) {

            var cherch = encodeURIComponent($("#pass").val());



            $.ajax({
                url: "<?= $this->url->get("default/controlpass") ?>?pass=" + cherch,
                type: 'GET',
                beforeSend: function () {
                    $('#passw').html(' <i class="now-ui-icons loader_refresh spin" style=" font-size: 20px; " width="200px"></i> ').fadeOut(300);
                    document.getElementById("but").disabled = -1;
                },
                complete: function () {
                    $('#passw').html(' <i class="now-ui-icons loader_refresh spin" style=" font-size: 20px; " width="200px"></i> ').fadeIn(300);
                    document.getElementById("but").disabled = 0;
                },
                success: function (html) {


                    $('#passw').html(html).fadeIn(500);

                }
            });

        } else {

            $('#passw').html("8 caractères minimum").show();
            document.getElementById("but").disabled = -1;
        }



    });

    $("#confirm").keyup(function () {
        var cherch = encodeURIComponent($("#pass").val());
        var confirm = encodeURIComponent($("#confirm").val());

        $.ajax({
            url: "<?= $this->url->get("default/controlpass") ?>?pass=" + cherch + "&&confirm=" + confirm,
            type: 'GET',
            success: function (html) {


                $('#passw').html(html).fadeIn(500);

            }
        });
    });



});

        </script>

    </body>
</html>
