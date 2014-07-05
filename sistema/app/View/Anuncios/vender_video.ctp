<h2>Vídeo do Anúncio</h2>


<?php
/* Cria um formulário com campo para pesquisa do vídeo */

 echo $this->Form->create('Anuncio', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal',
	'enctype'=>'multipart/form-data'
)); ?>
<h3>Novo vídeo</h3>

	<? echo $this->Form->input("pesquisar") ?>
	
	<div class="form-group">
		<?php echo $this->Form->submit('Pesquisar vídeo', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>

	
	
	<iframe id="player" type="text/html" width="640" height="360"
         src="https://www.youtube.com/embed/Xjn3XZ6IA_0" name="search_iframe"
         frameborder="0" allowfullscreen>
    </iframe>




<? echo $this->Form->end() ?>


<? 
/* Se foi feita pesquisa de vídeos, exibe a lista com o resultado da pesquisa */
if(isset($videos)){

?>
<?php echo $this->Form->create('Anuncio', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal',
	'enctype'=>'multipart/form-data'
)); ?>

<? 
/* Cria uma lista de vídeos, usando radio buttons, a partir da pesquisa feita pelo usuário */
echo $this->Form->radio("videos", $videos) ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Continuar', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<? echo $this->Form->end() ?>
<?	}
?>


<?php

	/* Caso o usuário não queria adicionar vídeo ao anúncio*/
	 echo $this->Form->create('Anuncio', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal',
	'enctype'=>'multipart/form-data',
	
));
?>
	 <div class="form-group">
		<?php echo $this->Form->submit('Prosseguir sem video', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
 

<? echo $this->Form->end() ?> 