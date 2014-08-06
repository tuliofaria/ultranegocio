<? 
	$this->set('channelData', array(
    'title' => __("RSS Anuncios no Ultranegocio.com"),
    'link' => $this->Html->url('/', true),
    'description' => __("Anuncios Ultranegocio.com"),
    'language' => 'pt-br'
));

foreach ($anuncios as $anuncio) {

    $anuncioTime = strtotime($anuncio['Anuncio']['created']);

    $anuncioLink = $this->Html->url('/anuncios/ver/'.$anuncio['Anuncio']['id'], true);

    // Remove & escape any HTML to make sure the feed content will validate.
    $bodyText = h(strip_tags($anuncio['Anuncio']['descricao']));
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));
    
    echo $this->Rss->item(array(), array(
        'title' => $anuncio['Anuncio']['titulo']." - R$".$anuncio['Anuncio']['preco'],
        'link' => $anuncioLink,
        'guid' => array('url' => $anuncioLink, 'isPermaLink' => 'true'),
        'description' => $anuncio['Anuncio']['descricao'],
        'pubDate' => $anuncio['Anuncio']['created']
    ));
}
//$this->set('documentData', $merda);

?>