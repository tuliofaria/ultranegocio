<h2>Vídeo do Anúncio</h2>


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
<h3>Novo vídeo</h3>

	<? echo $this->Form->input("pesquisar") ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Pesquisar vídeo', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<? echo $this->Form->end() ?>