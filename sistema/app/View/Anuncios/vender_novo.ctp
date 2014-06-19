<h2>Anuncio</h2>

<?php echo $this->Form->create('Anuncio', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal'
)); ?>
	<? echo $this->Form->input("titulo") ?>


	<? echo $this->Form->input("descricao", array("type"=>"textarea", "label"=>"Descrição")) ?>

	
	<? echo $this->Form->input("preco", array("label"=>"Preço")) ?>
	<h3>Para calcular frete</h3>
	<? echo $this->Form->input("peso", array("label"=>"Peso em gramas")) ?>
	<? echo $this->Form->input("cep_origem", array("label"=>"CEP de origem")) ?>
	<h3>Para SEO (ideal e funcionalidade futura: gerar automaticamente)</h3>
	<? echo $this->Form->input("keywords", array("label"=>"Keywords")) ?>
	<? echo $this->Form->input("description", array("label"=>"Description")) ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Salvar anuncio', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<? echo $this->Form->end() ?>