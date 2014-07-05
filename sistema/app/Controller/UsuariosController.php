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
				/*
				App::uses("CakeEmail", "Network/Email");
				$Email = new CakeEmail();
				$Email->config('smtp');
				$Email->template('boas_vindas', 'padrao');
				$Email->from(array("tuliofaria@gmail.com"=>"UltraNegocio"));
				$Email->to(array(
						$this->data["Usuario"]["email"]=>
							$this->data["Usuario"]["nome"]
				));
				$Email->subject("Confirme seu cadastro");
				$Email->viewVars(array("nome"=>$this->data["Usuario"]["nome"]));
				$Email->send();
				*/
				$id = $this->Usuario->id;
				$time = time();
				$check = sha1("ul".$id.$time."tra");

				$this->set("url", "/usuarios/conf/".$id."/".$time."/".$check);
				///usuarios/conf/$id/$time/check
			}
		}
	}
	public function conf($id, $time, $check) {
		$check2 = sha1("ul".$id.$time."tra");
		if($check==$check2) {
			$this->Usuario->id = $id;
			$this->Usuario->saveField("email_confirmado", 1);
			echo "confirmado";
			exit;
		}else{
			echo "nao ok";
			exit;
		}
	}



	//API
	public $components = array('RequestHandler');

    public function api_index() {
        $users = $this->Usuario->find('all', array(
            'fields' => array('Usuario.id', 'Usuario.nome', 'Usuario.email', 'Usuario.email_confirmado')));
        $this->set(array(
            'usuarios' => $users,
            '_serialize' => array('usuarios')
        ));
    }

    public function api_add() {
        $user = $this->Usuario->save($this->request->data);
        $this->Usuario->set("email_confirmado", true);
        $this->Usuario->save();
        $this->set(array(
            'id' => $user["Usuario"]["id"],
            '_serialize' => array('id')
        ));
    }

    public function api_view($id) {
        $user = $this->Usuario->findById($id);
        if($user) {
            $this->set(array(
                'user' => $user["Usuario"],
                '_serialize' => array("user")
            ));
        } else {
            $this->response->statusCode(404);
            $this->set(array(
                'message' => $id. " Not Found",
                '_serialize' => array("message")
            ));
        }
    }

    public function api_edit($id) {
        $this->Usuario->id = $id;
        if ($this->Usuario->save($this->request->data)) {
            $this->set(array(
                'message' => "User " . $id . " Saved",
                '_serialize' => array('message')
            ));
        } else {
            $this->response->statusCode(404);
            $this->set(array(
                'message' => $id. " Not Found",
                '_serialize' => array("message")
            ));
        }
        
    }

    public function api_delete($id) {
        if ($this->Usuario->delete($id)) {
            $message = 'Deleted '.$id;
        } else {
            $message = 'Error while deleting id: '.$id;
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function api_authorize() {
        $email = $this->request->data['user'];
        $user = $this->Usuario->findByEmail($email, array('Usuario.id', 'Usuario.nome', 
            'Usuario.email', 'Usuario.senha'));

        $passwd = $this->request->data['passwd'];

        if(!empty($user) && ($user["Usuario"]["senha"]==sha1($passwd))) {
            $message = "Authorized";
            unset($user["Usuario"]["senha"]);
            $this->set("user", $user["Usuario"]);
        } else {
            $this->response->statusCode(404);
            $message = "User and/or Password don't match";
            $user = array("user" => $email, "passwd" => $passwd);
            $this->set("user", $user);
        }
        $this->set("msg", $message);
        $this->set("_serialize", array('user', 'msg'));
    }

}