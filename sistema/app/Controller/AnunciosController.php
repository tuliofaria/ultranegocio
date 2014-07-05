<?php
class AnunciosController extends AppController {
	public $uses = array("Anuncio", "Imagem");

	public function index(){
		$this->set("anuncios", $this->paginate("Anuncio"));
	}
	public function ver($id){
		$this->set("a", $this->Anuncio->findById($id));
	}

	public function vender_novo() {
		if($this->request->is("post")){
			$this->request->data["Anuncio"]["usuario_id"] = $this->Session->read("usuario.Usuario.id");
			if($this->Anuncio->save($this->data)){
				$this->redirect("/vender/anuncios/fotos/".$this->Anuncio->id);
			}
		}
	}
	public function vender_fotos($id){
		if($this->request->is("post")){
			$dados = array();
			$dados["Imagem"] = $this->data["Anuncio"];
			$dados["Imagem"]["anuncio_id"] = $id;
			if($this->Imagem->save($dados)){
				// copiar foto
				move_uploaded_file($dados["Imagem"]["imagem"]["tmp_name"], WWW_ROOT."img".DS."fotos".DS.$this->Imagem->id.".jpg");
			}
		}
		$this->set("imagens", $this->Imagem->find("all", array("conditions"=>array("Imagem.anuncio_id"=>$id))));
	}

	public function vender_excluirfoto($id, $idA){
		$this->Imagem->delete($id);
		unlink(WWW_ROOT."img".DS."fotos".DS.$id.".jpg");
		$this->redirect("/vender/anuncios/fotos/".$idA);
	}



	//API
 	public $components = array('RequestHandler');

 	public function api_index() {
        $this->loadModel("Anuncio");
        $classified = $this->Anuncio->find('all', array(
            'fields' => array('Anuncio.id', 'Anuncio.descricao', 'Anuncio.preco', 
                'Anuncio.peso', 'Anuncio.cep_origem', 'Anuncio.keywords', 
                'Anuncio.description'),
            'recursive' => -1));
        $this->set(array(
            'anuncios' => $classified,
            '_serialize' => array('anuncios')
        ));
    }

    public function api_add() {
        $this->loadModel("Anuncio");
        $this->Anuncio->create($this->request->data);
        $anuncio = $this->Anuncio->save();
        $this->set(array(
            'id' => $anuncio["Anuncio"]["id"],
            '_serialize' => array('id')
        ));
    }

    public function api_view($id) {
        $this->loadModel("Anuncio");
        $anuncio = $this->Anuncio->findById($id);
        if($anuncio) {
            $this->set(array(
                'user' => $anuncio["Anuncio"],
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
        $this->loadModel("Anuncio");
        $this->Anuncio->id = $id;
        if ($this->Anuncio->save($this->request->data)) {
            $this->set(array(
                'message' => "Classified " . $id . " Saved",
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
        $this->loadModel("Anuncio");
        if ($this->Anuncio->delete($id)) {
            $message = 'Deleted '.$id;
        } else {
            $message = 'Error while deleting id: '.$id;
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}