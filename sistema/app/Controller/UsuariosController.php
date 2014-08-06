<?php
include("Facebook\FacebookSession.php");
include("Facebook\FacebookRedirectLoginHelper.php");
include("Facebook\FacebookRequest.php");
include("Facebook\FacebookSDKException.php");
include('Facebook\FacebookResponse.php');
include("Facebook\GraphObject.php");
include("Facebook\GraphSessionInfo.php");
include("Facebook\FacebookCanvasLoginHelper.php");
include("Facebook\GraphUser.php");

require_once('Facebook\FacebookResponse.php');
require_once('Facebook\FacebookHttpable.php' );
require_once('Facebook\FacebookCurlHttpClient.php' );
require_once('Facebook\FacebookCurl.php');
require_once('Facebook\FacebookRequestException.php');
require_once('Facebook\FacebookAuthorizationException.php');
require_once('Facebook\FacebookResponse.php');
require_once('Facebook\GraphObject.php');
require_once('Facebook\GraphSessionInfo.php');
require_once('Facebook\FacebookCanvasLoginHelper.php');
require_once('Facebook\GraphUser.php');

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSDKException;
use Facebook\FacebookHttpable;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookCurl;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookResponse;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
use Facebook\FacebookCanvasLoginHelper;

FacebookSession::setDefaultApplication('673510106020101','8b1e77ed95a02b285b56aed01acd2745');
class UsuariosController extends AppController {
    
	public function logout(){
		$this->getLogoutfacebook();		
		$this->Session->delete("usuario");
		$this->Session->destroy();		
		//$this->redirect("/");

		exit();		
	}

    public function getLogoutfacebook(){			
		$helper = new FacebookRedirectLoginHelper('http://localhost/ultranegocio/sistema/');
		//$UrlLogout=  $helper->getLogoutUrl(unserialize($_SESSION['sessaoFacebook']),
		//	'http://localhost/ultranegocio/sistema/');

		$user_profilerr= (new FacebookRequest(
				      unserialize($_SESSION['sessaoFacebook']), 'GET', '/me'
				    ))->execute()->getGraphObject(GraphUser::className());			  

		$UrlLogout = "https://www.facebook.com/logout.php?confirm=1?next=http://localhost/ultranegocio/sistema&access_token=".unserialize($_SESSION['sessaoFacebook'])->getToken();
		/*$params = array(
		      'next' => $next,
		      'access_token' => $session->getToken()
		    );
		    return 'https://www.facebook.com/logout.php?' . http_build_query($params);*/		
		
			//echo $UrlLogout;	
			//exit();

		header("Location: $UrlLogout");
	}			

	public function entrar() {
		if($this->request->is("post")){
			$usr = $this->Usuario->findByEmail($this->data["Usuario"]["email"]);
			if((!empty($usr))&&($usr["Usuario"]["senha"]==sha1($this->data["Usuario"]["senha"]))){
				if($usr["Usuario"]["email_confirmado"]==1){
					$this->Session->write("usuario", $usr);
					// TODO: redirecionar
					if($this->Session->check("redir")){
						$url = $this->Session->read("redir");
						$this->Session->delete("redir");
						$this->redirect("/".$url);
					}else{
						$this->redirect("/");
					}
				}else{
					$this->set("erroEmailNaoConfirmado", 1);
				}
			}else{
				$this->set("erroSenha", 1);
			}
		}
		/*if($this->request->is("post")){		
			$urlLoginFacebook = $this->getLoginUrl();
			//echo $urlLoginFacebook;			
			header("Location: $urlLoginFacebook");
				exit();			
		}*/
	}

	public function entrarlogin() {
				$urlLoginFacebook = $this->getLoginUrl();
				//echo $urlLoginFacebook;			
				header("Location: $urlLoginFacebook");
					exit();			
	}

	public function cadastro() {
		if($this->request->is("post")){
			if($this->Usuario->save($this->data)){
				
				App::uses("CakeEmail", "Network/Email");
				$Email = new CakeEmail();
				$Email->config('smtp');
				$Email->template('boas_vindas', 'padrao');
				$Email->from(array("ultranegocio@outlook.com"=>"ultranegocio.com"));
				$Email->to(array(
						$this->data["Usuario"]["email"]=>
							$this->data["Usuario"]["nome"]
				));
				$Email->subject("Confirme seu cadastro");
				$Email->viewVars(array("nome"=>$this->data["Usuario"]["nome"]));
				$Email->send();
				
				$id = $this->Usuario->id;
				$time = time();
				$check = sha1("ul".$id.$time."tra");

				$this->set("url", "/usuarios/conf/".$id."/".$time."/".$check);
				///usuarios/conf/$id/$time/check
			}
		}
	}
	public function conf($id, $time, $check){
		$check2 = sha1("ul".$id.$time."tra");
		if($check==$check2){
			$this->Usuario->id = $id;
			$this->Usuario->saveField("email_confirmado", 1);
			echo "confirmado";
			exit;
		}else{
			echo "nao ok";
			exit;
		}
	}
        
    public function getLoginUrl(){			
		$helper = new FacebookRedirectLoginHelper('http://localhost/ultranegocio/sistema/usuarios/facebooklogin');
		$UrlLogin= $helper->getLoginUrl();		
		return $UrlLogin."email";	//para pedir permissão de e-mail	
	}	
        
        public function facebooklogin(){
		$helper = new FacebookRedirectLoginHelper('http://localhost/ultranegocio/sistema/usuarios/facebooklogin');
		try {
		  $session = $helper->getSessionFromRedirect();
		} catch(FacebookRequestException $ex) {		
		  var_dump($ex);
		  exit();		  
		} catch(\Exception $ex) {
		  var_dump($ex);
		  exit();		  
		}
		if ($session) {
                    $_SESSION['logado'] = true;
                    $_SESSION['sessaoFacebook'] = serialize($session);
			
			 try {
				$user_profile = (new FacebookRequest(
				      $session, 'GET', '/me'
				    ))->execute()->getGraphObject(GraphUser::className());			  

				$emailfacebook = (new FacebookRequest(
				      $session, 'GET', '/me?fields=email'
				    ))->execute()->getGraphObject();			  
		
			  //  print_r($emailfacebook.getProperty('email'));
				//var_dump($emailfacebook->getProperty('email'));
			   // echo "Name: " . $emailfacebook->getProperty('email');
			    //echo "Name: " . $user_profile->getName();
			    //exit();
			    //$requestEmail = "raulreisimom@bol.com.br";

			  } catch(FacebookRequestException $e) {
			    echo "Exception occured, code: " . $e->getCode();
			    echo " with message: " . $e->getMessage();
			  }			  

                    //pegar o e-mail do $session, como eu não sei o atributo você deve descobrir qual é
                    $usr = $this->Usuario->findByEmail($emailfacebook->getProperty('email'));
                    if(empty($usr)){
                        //pegar o e-mail do $session, como eu não sei o atributo você deve descobrir qual é
						$matriz{'Usuario'}  = array(
						       "email" => $emailfacebook->getProperty('email'),
						       "nome" => $user_profile->getName(),
						       "email_confirmado" => 1
						);                        
                        $this->Usuario->save($matriz);
                        $usr = $matriz;
                    }
                       
                    $this->Session->write("usuario", $usr);
                    if($this->Session->check("redir")){
						$url = $this->Session->read("redir");
						$this->Session->delete("redir");
						$this->redirect("/".$url);
                    }else{
						$this->redirect("/");
                    }
		}else{
			//erro
		}
	}
}