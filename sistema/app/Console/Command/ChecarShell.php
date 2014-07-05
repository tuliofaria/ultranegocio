<?
class ChecarShell extends AppShell {
	public $uses = array("Categoria");
    public function main() {
        $this->out('Enviando emails pendentes', 1, Shell::QUIET);
        $cats = $this->Categoria->generateTreeList(null,null,null, '--');
        foreach($cats as $c){
        	$this->out($c);
        }

    }
}