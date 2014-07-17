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
        <? echo $this->Form->input("id", array('type'=> 'hidden', 'value' => $a["Anuncio"]["id"])) ?>
	<? echo $this->Form->input("titulo", array('value' => $a["Anuncio"]["titulo"])) ?>


	<? echo $this->Form->input("descricao", array("type"=>"textarea", "label"=>"Descrição", 'value' => $a["Anuncio"]["descricao"])) ?>

	
	<? echo $this->Form->input("preco", array("label"=>"Preço", 'value' => $a["Anuncio"]["preco"])) ?>
	<h3>Para calcular frete</h3>
	<? echo $this->Form->input("peso", array("label"=>"Peso em gramas", 'value' => $a["Anuncio"]["peso"])) ?>
	<? echo $this->Form->input("cep_origem", array("label"=>"CEP de origem", 'value' => $a["Anuncio"]["cep_origem"])) ?>
	<h3>Para SEO</h3>
        
	<? echo $this->Form->input("keywords", 
            array(
                "label"=>"
                    <a data-original-title='As palavras devem ser separadas por vírgula e possuir no total o máximo de 250 caracteres. ( Relevante para alguns mecanismos de pesquisa. )' href='#' rel='tooltip' title='' class='aTooltip'>
                        &nbsp;?&nbsp;
                    </a>
                    Keywords
                ", 'value' => $a["Anuncio"]["keywords"]
            )
        ) ?>
	<? echo $this->Form->input("description", 
            array(
                "label"=>"
                    <a data-original-title='A descrição deve possuir no máximo 160 caracteres. ( Se estiver vazio, será gerado pelo mecanismo de pesquisa. )' href='#' rel='tooltip' title='' class='aTooltip'>
                        &nbsp;?&nbsp;
                    </a>
                    Description
                ", 'value' => $a["Anuncio"]["description"]
            )
        ) ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Salvar anuncio', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<? echo $this->Form->end() ?>