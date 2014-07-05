<h2>Categorias</h2>

<? foreach($categorias as $id=>$c){ ?>
	<? echo $c ?> (<? echo $id ?>) <a class="btn" href="<? echo $this->Html->url("/admin/categorias/moveUp/".$id) ?>">move up</a> | <a class="btn" href="<? echo $this->Html->url("/admin/categorias/moveDown/".$id) ?>">move down</a><br>
<? } ?>