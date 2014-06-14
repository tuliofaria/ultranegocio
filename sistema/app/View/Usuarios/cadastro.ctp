<h2>Novo usuário</h2>

<? echo $this->Form->create("Usuario") ?>
	<? echo $this->Form->input("nome") ?>
	<? echo $this->Form->input("email") ?>
	<? echo $this->Form->input("senha", array("type"=>"password")) ?>
	<? echo $this->Form->input("senha2", array("label"=>"Confirmar senha", "type"=>"password")) ?>
<? echo $this->Form->end("Cadastrar") ?>


<? if(isset($url)){ ?>
	<a href="<? echo $this->Html->url($url) ?>">ativar</a>
<? } ?>