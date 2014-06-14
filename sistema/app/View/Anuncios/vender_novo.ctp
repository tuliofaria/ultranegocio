<h2>Anuncio</h2>

<? echo $this->Form->create("Anuncio") ?>
	<? echo $this->Form->input("titulo") ?>
	<? echo $this->Form->textarea("descricao") ?>
	<? echo $this->Form->input("preco") ?>
<? echo $this->Form->end("Entrar") ?>