<!DOCTYPE html>
<html lang="en">
  <head>
  	<?php echo $this->Html->charset(); ?>
      <?php 
        if(!isset($description)){
            $description = "Ultranegocio.com.br";
        }
        if(!isset($keywords)){
            $keywords = "Anuncions, Online, Ultranegocio, Vender, Comprar";
        }
      ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php echo $keywords ?>">
    <meta name="description" content="<?php echo $description ?>">
    <title>UltraNegócio.com :
		<?php echo $title_for_layout; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo $this->Html->url("/") ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->Html->url("/") ?>css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <script src="<?php echo $this->Html->url("/") ?>js/bootstrap.js"></script>
    <script src="<?php echo $this->Html->url("/") ?>js/jquery.js"></script>
    <script src="<?php echo $this->Html->url("/") ?>js/bootstrap-tooltip.js"></script>
    <script src="<?php echo $this->Html->url("/") ?>js/bootstrap-carousel.js"></script>
    <!--[if lt IE 9]>
      <script src="<?php echo $this->Html->url("/") ?>js/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="padding-top: 50px;">
<script type='text/javascript'>
    jQuery(function ($) {
        $('.aTooltip').tooltip();
    });
</script>
    <div class="navbar navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Mostrar navegação</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<? echo $this->Html->url("/") ?>">UltraNegócio.com</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<? echo $this->Html->url("/") ?>">Home</a></li>
            <li><a href="<? echo $this->Html->url("/anuncios") ?>">Comprar</a></li>
            <li><a href="<? echo $this->Html->url("/vender/anuncios/listar") ?>">Vender</a></li>
            <li><a href="<? echo $this->Html->url("/usuarios/logout") ?>">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

	<div class="container">
	    <?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>

	<div id="footer" class="text-center">
                <h4 class="textoFooter">UltraNegócio.com - 2001-<? echo date("Y") ?> </h4>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<? echo $this->Html->url("/") ?>js/bootstrap.min.js"></script>


    <?php echo $this->element('sql_dump'); ?>

    <script>
    	$(function(){
    		$(".message").addClass("alert alert-success").hide().fadeIn().delay(15000).fadeOut();
    	});
    </script>

  </body>
</html>