<?php
	class Anuncio extends AppModel{

		public $hasMany = array("Imagem");
		public $belongsTo = array("Usuario");
	}