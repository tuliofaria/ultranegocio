<?php
	class Usuario extends AppModel{

		public $validate = array(
			"email"=>array(
				"emailValido"=>array(
					"rule"=>"email",
					"message"=>"Por favor, informe um e-mail válido."
				),
				"emailUnico"=>array(
					"rule"=>"isUnique",
					"message"=>"Este e-mail já está cadastrado."
				)
			),
			"nome"=>array(
				"nomeNaoVazio"=>array(
					"rule"=>"notEmpty",
					"message"=>"Por favor, informe seu nome2."
				)
			),
			"senha"=>array(
				"senhaNaoVazio"=>array(
					"rule"=>"notEmpty",
					"message"=>"Por favor, informe sua senha."
				)
			),
			"senha2"=>array(
				"senhaIgual"=>array(
					"rule"=>array("senhasIguais"),
					"message"=>"Por favor, a confirmação de senha...."
				)
			)
		);
		public function senhasIguais($p){
			if($p["senha2"]!=$this->data["Usuario"]["senha"]){
				return false;
			}
			return true;
		}

		public function beforeSave($options = array()) {
			if(isset($this->data["Usuario"]["senha"])){
				$this->data["Usuario"]["senha"] = sha1($this->data["Usuario"]["senha"]);
			}
			return true;
		}
	}