<?php
class ImagensController extends AppController {
    public $components = array('RequestHandler');
    public $uses = array("Imagem");

    public function api_index() {
        if(isset($this->request->query['anuncio_id'])) {
            $images = $this->Imagem->find('all', array(
            'fields' => array('Imagem.id', 'Imagem.titulo', 'Imagem.descricao', 
                'Imagem.alt', "Imagem.url"),
            'conditions' => array('Imagem.anuncio_id' => $this->request->query['anuncio_id'])));
        } else {
            $images = $this->Imagem->find('all', array(
            'fields' => array('Imagem.id', 'Imagem.titulo', 'Imagem.descricao', 
                'Imagem.alt', 'Imagem.anuncio_id', 'Imagem.url')));
        }

        $this->set(array(
            'imagens' => $images,
            '_serialize' => array('imagens')
        ));
    }

    public function api_add() {
        $imagem = $this->Imagem->save($this->request->data);
        
        $this->Imagem->set('url', Router::url('/img/fotos/'.$this->Imagem->id.'.jpg', true));
        $this->Imagem->save();
        // Convert from Base64 to jpg file
        $output_file = WWW_ROOT."img".DS."fotos".DS.$this->Imagem->id.".jpg";
        $file = $this->base64_to_jpeg($this->request->data["img"], $output_file);
        
        $this->set(array(
            'id' => $imagem["Imagem"]["id"],
            '_serialize' => array('id')
        ));
    }

    public function api_view($id) {
        $imagem = $this->Imagem->findById($id);
        if($imagem) {
            $this->set(array(
                'image' => $imagem["Imagem"],
                '_serialize' => array("image")
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
        $this->Imagem->id = $id;
        if ($this->Imagem->save($this->request->data)) {
            $this->set(array(
                'message' => "Imagem " . $id . " Saved",
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
        if ($this->Imagem->delete($id)) {
            $message = 'Deleted '.$id;
        } else {
            $message = 'Error while deleting id: '.$id;
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    function base64_to_jpeg( $base64_string, $output_file ) {
        $ifp = fopen( $output_file, "wb" ); 
        fwrite( $ifp, base64_decode( $base64_string) ); 
        fclose( $ifp ); 
        return( $output_file ); 
    }
}