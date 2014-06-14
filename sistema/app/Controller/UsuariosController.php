<?php
class UsuariosController extends AppController {

	public function entrar() {

	}

	public function cadastro() {
		if($this->request->is("post")){
			if($this->Usuario->save($this->data)){
				// TODO
			}
		}
	}

}