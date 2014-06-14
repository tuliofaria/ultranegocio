<?php
class AnunciosController extends AppController {
	public function vender_novo() {
		if($this->request->is("post")){
			$this->request->data["Anuncio"]["usuario_id"] = $this->Session->read("usuario.Usuario.id");
			if($this->Anuncio->save($this->data)){
				$this->redirect("/vender/anuncios/fotos/".$this->Anuncio->id);
			}
		}
	}
}