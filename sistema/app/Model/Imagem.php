<?php
	class Imagem extends AppModel{

		public $useTable = "imagens";

		public $validate = array(
			"titulo"=>array(
				"nomeNaoVazio"=>array(
					"rule"=>"notEmpty",
					"message"=>"Por favor, informe o título da foto."
				)
			),
		);
	}