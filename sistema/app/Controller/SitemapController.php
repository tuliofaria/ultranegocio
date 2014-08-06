<?php
require_once '/../Model/SitemapService.php';
class SitemapController extends AppController {
        var $uses = false;
	public function index(){
		$service = new SitemapService();
                $service->generate();
	}
}