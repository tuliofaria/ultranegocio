<?php
require_once '/../Model/PagSeguroService.php';
class DestaqueController extends AppController {

    public $uses = array("Destaque", "Anuncio");

    public function index() {
    }
    
    public function vender_novo($anuncioId){
        $anuncio = $this->Anuncio->findById($anuncioId);
        $destaque = array();
        $destaque["anuncio_id"] = $anuncio["Anuncio"]["id"];
        $destaque["valor"] = 5.00;
        $this->Destaque->save($destaque);
        $service = new PagSeguroService();
        $destaque = $this->Destaque->findById($this->Destaque->id);
        $url = $service->efetuarPagamento($destaque);
        $this->set("link", $url);
    }
}
