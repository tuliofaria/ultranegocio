<h2>Por favor identifique-se</h2>
<? if(isset($erroEmailNaoConfirmado)){ ?>
	<p class="alert alert-warning">E-mail nao confirmado</p>
<? } ?>
<? if(isset($erroSenha)){ ?>
	<p class="alert alert-warning">Email ou senha invalidos</p>
<? } ?>
<? echo $this->Form->create("Usuario") ?>
	<? echo $this->Form->input("email") ?>
	<? echo $this->Form->input("senha", array("type"=>"password")) ?>
<? echo $this->Form->end("Entrar") ?>
<p><a class="btn btn-lg btn-info" href="<? echo $this->Html->url("/usuarios/entrarlogin") ?>">Login Face</a></p>
<h2>Não tem cadastro? Cadastre-se agora</h2>
<p><a class="btn btn-lg btn-info" href="<? echo $this->Html->url("/usuarios/cadastro") ?>">Fazer cadastro</a></p>
