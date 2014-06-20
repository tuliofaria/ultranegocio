<h2>Anuncios</h2>

<? if(count($anuncios)==0){ ?>
	<p class="alert alert-info">Nenhum anuncio feito até o momento.</p>
<? }else{ ?>
	<table class="table">
		<? foreach($anuncios as $a){ ?>
		<tr>
			<td>
                            <a href="<? echo $this->Html->url("/anuncios/ver/".$a["Anuncio"]["id"]) ?>" title="<? echo $a["Anuncio"]["titulo"] ?>">
				<img src="<? echo $this->Html->url("/img/fotos/".$a["Imagem"][0]["id"].".jpg") ?>" class="img-thumbnail" width="200" />
                            </a>
			</td>
			<td>
                            <a href="<? echo $this->Html->url("/vender/anuncios/novo/".$a["Anuncio"]["id"]) ?>" title="<? echo $a["Anuncio"]["titulo"] ?>">Editar</a>
                        </td>
                        <td>
                            <a href="<? echo $this->Html->url("/vender/destaque/novo/".$a["Anuncio"]["id"]) ?>" title="<? echo $a["Anuncio"]["titulo"] ?>">Comprar Destaque</a>
                        </td>
                </tr>
		<? } ?>
	</table>
<? } ?>