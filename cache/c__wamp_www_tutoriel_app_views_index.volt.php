<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Phalcon PHP Framework</title>
        <link rel="stylesheet" href="<?= $this->url->getBaseUri();?>public/vendor/bootstrap-3.3.7/dist/css/bootstrap.min.css">
    </head>
    <body>
 <?php
    if ($this->session->has('id'))  {
        
    
        ?>

        <nav class="navbar navbar-inverse navbar-fixed-top">
        
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $this->url->getBaseUri();?>index/index">Acceuil</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">


                <li><a href="<?= $this->url->getBaseUri();?>filiere">FILIERE</a></li>

                <li><a href="<?= $this->url->getBaseUri();?>etudiant">ETUDIANT</a></li>
                <li> <a href="<?= $this->url->getBaseUri();?>user/deconnection?>"><button type="button" class="btn btn-primary">Deconnection</button></a></li>
            
            </ul>
            

        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<?php
    
    }else {

        
    }
    ?>
</br></br>
        <div class="container">
            <?= $this->getContent() ?>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?= $this->url->getBaseUri();?>public/vendor/bootstrap-3.3.7/dist/js/vendor/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="<?= $this->url->getBaseUri();?>public/vendor/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
        <script>
            $(function() {
$('.sup[data-confirm]').click(function(ev) {
var href = $(this).attr('href');
if (!$('#dataConfirmModal').length) {
$('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Merci de confirmer</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Non</button><a class="btn btn-danger"  id="dataConfirmOK">Oui</a></div></div></div></div>');
} $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm')); $('#dataConfirmOK').attr('href', href); $('#dataConfirmModal').modal({show:true} ); $('#dataConfirmOK').click(function(){$('.sup').$('.a_sup').click();});
return false;
});
});

        </script>
    </body>
</html>
