<h2><? echo $a["Anuncio"]["titulo"] ?></h2>
<p><? echo $a["Anuncio"]["descricao"] ?></p>

	<table class="table">
		<? foreach($a["Imagem"] as $i){ ?>
		<tr>
			<td>
				<img src="<? echo $this->Html->url("/img/fotos/".$i["id"].".jpg") ?>" class="img-thumbnail" width="200" />
			</td>
		</tr>
		<? } ?>
	</table>