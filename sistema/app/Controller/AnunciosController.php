<?php

class AnunciosController extends AppController {

    public $uses = array("Anuncio", "Imagem");

    public function index() {
        $this->set("anuncios", $this->paginate("Anuncio"));
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
                $this->redirect("/vender/anuncios/fotos/" . $this->Anuncio->id);
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

}
