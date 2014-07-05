<?php
	class Video extends AppModel{

		/* Variável que define o nome da tabela do banco de dados correspondente a esta classe Modelo */
		public $useTable = "videos";

		/**
		Método que realiza a busca de um vídeo no YouTube
		*/
		public function pesquisar_video($pesquisa){
		
			$youtube = $this->get_youtube_service();

		 	try{
			  	//Chamada do metodo search.list para pegar os resultados do campo de busca.
			  	$searchResponse = $youtube->search->listSearch('id,snippet', array(
			  		'q' => $pesquisa,
			  		'maxResults' => 15,
			  	));

			  	//Coloca os resultados na lista apropriada e mostra os resultado
			  	foreach ($searchResponse['items'] as $searchResult) {
			  		switch ($searchResult['id']['kind']) {
			  			case 'youtube#video':

			  				//ID do Vídeo do YouTube
			  				$videoID = $searchResult['id']['videoId'];

			  				//Link que será usado no HTML para acessar o vídeo do YouTube
			  				$videoLink = "<a href=https://www.youtube.com/embed/".$searchResult['id']['videoId']." target=search_iframe>".$searchResult['snippet']['title']."</a>";

			  				//Cria uma lista com os vídeos da pesquisa, seus IDs e o link
			  				$listaVideos[$videoID] = $videoLink;

			  				break;
			  			
			  			default:
			  				
			  				break;
			  			}
			  		}
			 	} catch (Google_ServiceException $e) {
			    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
			      htmlspecialchars($e->getMessage()));
			  	} catch (Google_Exception $e) {
			    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
			      htmlspecialchars($e->getMessage()));
		  	}
		  return $listaVideos;
		}

		/* Método que faz as configurações exigidas pela Google API para pesquisar dados no YouTube */
		public function get_youtube_service(){

			//Chamando os serviços necessários
			require_once 'Google/Client.php';
			require_once 'Google/Service/YouTube.php';

			//Key registrada no google developer para ter acesso aos recursos da API
			$DEVELOPER_KEY = 'AIzaSyAR5Zr8-Jl4i9wjD7JGuhxzfMXRe_usADA';

			$client = new Google_Client();
			$client->setDeveloperKey($DEVELOPER_KEY);

			//Cria o objeto para fazer as requisicoes para a API
			$youtube = new Google_Service_Youtube($client);
			return $youtube;
		}


	}
	