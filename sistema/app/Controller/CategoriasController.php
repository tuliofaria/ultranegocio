<?php
	class CategoriasController extends AppController{


		public function admin_index(){
			$this->set("categorias", 
				$this->Categoria->generateTreeList(null, null, null, ' = ')
			);
		}
		public function admin_nova(){
			$this->set("parents", $this->Categoria->generateTreeList(null, null, null, '--'));
			if($this->request->is("post")){
				if($this->Categoria->save($this->data)){
					$this->redirect("/admin/categorias/");
				}
			}
		}

		public function admin_moveUp($id){
			$this->Categoria->id = $id;
			$this->Categoria->moveUp();
			$this->redirect("/admin/categorias/");
		}
		public function admin_moveDown($id){
			$this->Categoria->id = $id;
			$this->Categoria->moveDown();
			$this->redirect("/admin/categorias/");
		}

	}