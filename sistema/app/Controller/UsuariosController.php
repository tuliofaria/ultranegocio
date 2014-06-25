<?php
class UsuariosController extends AppController {

	public function logout(){
		$this->Session->delete("usuario");
		$this->Session->destroy();

		$this->redirect("/");
	}

	public function entrar() {
		if($this->request->is("post")){
			$usr = $this->Usuario->findByEmail($this->data["Usuario"]["email"]);
			if((!empty($usr))&&($usr["Usuario"]["senha"]==sha1($this->data["Usuario"]["senha"]))){
				if($usr["Usuario"]["email_confirmado"]==1){
					$this->Session->write("usuario", $usr);
					// TODO: redirecionar
					if($this->Session->check("redir")){
						$url = $this->Session->read("redir");
						$this->Session->delete("redir");
						$this->redirect("/".$url);
					}else{
						$this->redirect("/");
					}
				}else{
					$this->set("erroEmailNaoConfirmado", 1);
				}
			}else{
				$this->set("erroSenha", 1);
			}
		}
	}

	public function cadastro() {
		if($this->request->is("post")){
			if($this->Usuario->save($this->data)){
				
				App::uses("CakeEmail", "Network/Email");
				$Email = new CakeEmail();
				$Email->config('smtp');
				$Email->template('boas_vindas', 'padrao');
				$Email->from(array("ultranegocio@outlook.com"=>"ultranegocio.com"));
				$Email->to(array(
						$this->data["Usuario"]["email"]=>
							$this->data["Usuario"]["nome"]
				));
				$Email->subject("Confirme seu cadastro");
				$Email->viewVars(array("nome"=>$this->data["Usuario"]["nome"]));
				$Email->send();
				
				$id = $this->Usuario->id;
				$time = time();
				$check = sha1("ul".$id.$time."tra");

				$this->set("url", "/usuarios/conf/".$id."/".$time."/".$check);
				///usuarios/conf/$id/$time/check
			}
		}
	}
	public function conf($id, $time, $check){
		$check2 = sha1("ul".$id.$time."tra");
		if($check==$check2){
			$this->Usuario->id = $id;
			$this->Usuario->saveField("email_confirmado", 1);
			echo "confirmado";
			exit;
		}else{
			echo "nao ok";
			exit;
		}
	}

}