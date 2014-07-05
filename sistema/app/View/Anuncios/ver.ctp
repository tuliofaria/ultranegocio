<h2><? echo $a["Anuncio"]["titulo"] ?></h2>
<p><? echo $a["Anuncio"]["descricao"] ?></p>
<p><? echo $a["Anuncio"]["preco"] ?> reais</p>

	<table class="table">
		<? 
		foreach($a["Imagem"] as $i){ ?>
		<tr>
			<td>
				<img src="<? echo $this->Html->url("/img/fotos/".$i["id"].".jpg") ?>" class="img-thumbnail" width="200" />
			</td>
		</tr>
		<? } ?>
		<tr>
			<? 
			/* Verifica se existe um vídeo para o anúncio, e exibe na tela usando um iframe */
			if($a["Video"]["id"] != null){
			 ?>
			<td>
				<iframe id="player" type="text/html" width="640" height="360"
         src="https://www.youtube.com/embed/<?echo $a["Video"]["url"]?>" name="search_iframe"
         frameborder="0" allowfullscreen>
          </iframe>
			</td>
			<? } ?>
		</tr>
	</table>