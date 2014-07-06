<?php
class SitemapService {

    public function generate() {
        App::import('model','Anuncio');
        App::import('Helper', 'Html');
        $filename = $arq = WWW_ROOT."sitemap.xml";
        if(file_exists($filename)){
            unlink($filename);
        }
        $html = new HtmlHelper();        
        $anuncio = new Anuncio();
        $anuncios = $anuncio->find('all');        
        $anuncio_xml = "<?xml version='1.0' encoding='UTF-8'?>
                    <urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9' xmlns:image='http://www.google.com/schemas/sitemap-image/1.1'>                
                    ";
        foreach ($anuncios as $a) {
            $anuncio_xml .= "
                        <url>
                            <loc>" . $html->url("/anuncios/ver/".$a["Anuncio"]["id"], true)  . "</loc>
                            ";
            $fotos = $a["Imagem"];
            if (isset($fotos)) {
                foreach ($fotos as $foto) {
                    $anuncio_xml .= "<image:image>
                                         <image:loc>" . $html->url("/img/fotos/" . $foto["id"] . ".jpg", true)  . "</image:loc>
                                         <image:title>" . $foto["titulo"]  . "</image:title>
                                         <image:caption>" . $foto["alt"]  . "</image:caption>
                                         </image:image> ";
                }
            }
            $anuncio_xml .= "
                            <lastmod>" . $a["Anuncio"]["modified"]. "</lastmod>
                            <changefreq>weekly</changefreq>
                            <priority>0.8</priority>
                        </url>
                    ";
        }
        $anuncio_xml .= "</urlset>";
        $arq = WWW_ROOT."sitemap.xml";
        file_put_contents($arq, $anuncio_xml, FILE_TEXT);
        unset($arq);
    }

}


