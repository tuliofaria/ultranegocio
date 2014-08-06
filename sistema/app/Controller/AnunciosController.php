<?php

class AnunciosController extends AppController {

	/* Variável que define quais classes Modelo o Controller irá acessar */
	public $uses = array("Anuncio", "Imagem", "Video");

	//rss
	public $components = array('RequestHandler');
	public $helpers = array('Text', 'Html');

    public function index(){
		if ($this->RequestHandler->isRss() ) {
	        $anuncios = $this->Anuncio->find(
	            'all',
	            array('limit' => 20, 'order' => 'Anuncio.created DESC')
	        );
	        $this->set(compact('anuncios'));
	    }else{
	        $this->paginate['Anuncio'] = array(
	        	'order' => 'Anuncio.created DESC',
	        	'limit' => 10
	    	);
			$anuncios = $this->paginate();
			$this->set(compact('anuncios'));
		}
	}

    public function ver($id) {
        $anuncio = $this->Anuncio->findById($id);
        $this->set("a", $anuncio);
        $this->set("keywords", $anuncio["Anuncio"]["keywords"]);
        $this->set("description", $anuncio["Anuncio"]["description"]);
    }

    public function vender_listar() {
        if ($this->request->is("get")) {
            $usuarioId = $this->Session->read("usuario.Usuario.id");
            $anuncios = $this->Anuncio->findAllByUsuario_id($usuarioId);
            $this->set("anuncios", $anuncios);
        }
    }

    public function vender_novo($id) {
        if ($this->request->is("post")) {
            $this->request->data["Anuncio"]["usuario_id"] = $this->Session->read("usuario.Usuario.id");
            if ($this->Anuncio->save($this->data)) {
                /* Inserir novo vídeo */
				$this->redirect("/vender/anuncios/video/".$this->Anuncio->id);
            }
        } else if ($this->request->is("get")) {
            $anuncio = $this->Anuncio->findById($id);
            $this->set("a", $anuncio);
        }
    }

    public function vender_fotos($id) {
        if ($this->request->is("post")) {
            $dados = array();
            $dados["Imagem"] = $this->data["Anuncio"];
            $dados["Imagem"]["anuncio_id"] = $id;
            if ($this->Imagem->save($dados)) {
                // copiar foto
                move_uploaded_file($dados["Imagem"]["imagem"]["tmp_name"], WWW_ROOT . "img" . DS . "fotos" . DS . $this->Imagem->id . ".jpg");
            }
        }
        $this->set("imagens", $this->Imagem->find("all", array("conditions" => array("Imagem.anuncio_id" => $id))));
    }

    public function vender_excluirfoto($id, $idA) {
        $this->Imagem->delete($id);
        unlink(WWW_ROOT . "img" . DS . "fotos" . DS . $id . ".jpg");
        $this->redirect("/vender/anuncios/fotos/" . $idA);
    }


	/* Adicionar um vídeo ao anúncio */
	public function vender_video($id){
		$dados = array();

		$this->set("anuncioId", $id);

		if($this->request->is("post") && empty($this->data["Anuncio"]["pesquisar"]) && !isset($this->data["Anuncio"]["videos"])){

			/* Usuário não quer inserir vídeos. Redireciona para a página de salvar fotos */
			$this->redirect("/vender/anuncios/fotos/".$id);
		}

		if($this->request->is("post") && isset($this->data["Anuncio"]["pesquisar"])){

			/* Usuário digitou uma palavra para pesquisqr por um vídeo*/
			$dados["Video"] = $this->data["Anuncio"];
			$dados["Video"]["anuncio_id"] = $id;

			/* Chama o método que realiza a pesquisa de um vídeo no YouTube */
			$videos = $this->Video->pesquisar_video($dados["Video"]["pesquisar"]);
			$this->set("videos", $videos);
		}

		if($this->request->is("post") && isset($this->data["Anuncio"]["pesquisar"]) == false){

			/* Usuário escolheu um vídeo para salvar no anúncio*/

			$dados["Video"] = $this->data["Anuncio"];
			$dados["Video"]["anuncio_id"] = $id;
			$dados["Video"]["url"] = $dados["Video"]["videos"];

			/*Salva no banco de dados*/
			$this->Video->save($dados);

			/* Redireciona para a página de salvar fotos */
			$this->redirect("/vender/anuncios/fotos/".$id);
		}
	}

	public function vender_excluirfoto($id, $idA){
		$this->Imagem->delete($id);
		unlink(WWW_ROOT."img".DS."fotos".DS.$id.".jpg");
		$this->redirect("/vender/anuncios/fotos/".$idA);
	}
}