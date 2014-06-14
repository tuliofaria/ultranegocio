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
			)
		);
	}