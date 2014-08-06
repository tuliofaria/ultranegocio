<h1 class="anuncio anuncioTitulo">
    <? echo $a["Anuncio"]["titulo"] ?>
</h1>
<small>
    Criado em: <? echo $a["Anuncio"]["created"] ?>
</small>
<br/>
    <div class='carousel slide pull-left' id='myCarousel' style='margin-top: 20px; margin-right: 50px; max-width: 690px; max-height=500px'>
        <div class='carousel-inner'>
        <?php 
        if(isset($a["Imagem"])){
            $flag = true;
            foreach($a["Imagem"] as $i){ 
        ?>
            <?php if($flag){ 
                $flag = false;
            ?>
                <div class='item active'>
            <?php }else{ ?>
                <div class='item'>
            <?php } ?>
                    <a href="<? echo $this->Html->url("/img/fotos/".$i["id"].".jpg") ?>" title="<?php echo $i["titulo"] ?> | ultranegocio.com.br" class="link linkImagem" target="_blank">
                        <img src="<? echo $this->Html->url("/img/fotos/".$i["id"].".jpg") ?>" title="<?php echo $i["titulo"] ?>" alt="<?php echo $i["alt"] ?>" class="img-thumbnail" width="500" />
                    </a>
                </div>
        <?php 
            }
        }else{
        ?>
                <div class='item active'>
                    <a href="Sem Imagem | ultranegocio.com.br" class="link linkImagem" target="_blank">
                        <img src="<? echo $this->Html->url("/img/no-image.png") ?>" title="Sem Imagem" alt="Anuncio sem imagem" class="img-thumbnail" width="500" />
                    </a>
                </div>
        <?php
        }
        ?>
        </div>
        <?php
        if(isset($a["Imagem"]) && count($a["Imagem"]) > 1){
        ?>
            <a data-slide='prev' href='#myCarousel' class='left carousel-control'>‹</a>
            <a data-slide='next' href='#myCarousel' class='right carousel-control'>›</a>
        <?php
        }
        ?>
    </div>
    <div class='infoAnuncio'>
        <h3>Dados do anunciante</h3>
        <p>
            Nome: <?php echo $a["Usuario"]["nome"] ?>
            <br/>
            Email: <?php echo $a["Usuario"]["email"] ?>
        </p>
        <h3>Detalhes do anuncio</h3>
        <p>
            Preço: <? echo $a["Anuncio"]["preco"] ?>
            <br/>
            Peso: <? echo $a["Anuncio"]["peso"] ?>
        </p>
        <h3>Localização</h3>
        <? echo $a["Anuncio"]["cep_origem"] ?>
        <div class="descricaoAnuncio">
            <h3>Descrição do anuncio</h3>
            <? echo $a["Anuncio"]["descricao"] ?>
        </div>
    </div>