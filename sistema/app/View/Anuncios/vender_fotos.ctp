<h2>Fotos do anuncio</h2>

<? if(count($imagens)==0){ ?>
	<p class="alert alert-info">Nenhuma foto enviada até o momento.</p>
<? }else{ ?>
	<table class="table">
		<? foreach($imagens as $i){ ?>
		<tr>
			<td>
				<img src="<? echo $this->Html->url("/img/fotos/".$i["Imagem"]["id"].".jpg") ?>" class="img-thumbnail" width="200" />
			</td>
			<td><a href="<? echo $this->Html->url("/vender/anuncios/excluirfoto/".$i["Imagem"]["id"]."/".$i["Imagem"]["anuncio_id"]) ?>">Excluir</a></tr>
		<? } ?>
	</table>
<? } ?>

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
	<h3>Nova foto</h3>
	<? echo $this->Form->input("titulo") ?>
	<? echo $this->Form->input("descricao", array("type"=>"textarea", "label"=>"Descrição")) ?>
	<? echo $this->Form->input("imagem", array("type"=>"file", "label"=>"Escolhar arquivo")) ?>

	<h3>Para SEO (ideal e funcionalidade futura: gerar automaticamente)</h3>
	<? echo $this->Form->input("alt", array("label"=>"Texto alternativo")) ?>

	<div class="form-group">
		<?php echo $this->Form->submit('Enviar foto', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<? echo $this->Form->end() ?>