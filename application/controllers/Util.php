<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Util extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url','file','ckeditor_helper','download'));
		$this->load->model(array('menu_model','board_model','popup_model'));
		$this->load->library(array('email','user_agent','form_validation','alert','session'));
	}

	function download(){
		$file_full_path = FCPATH.'upload/'.$this->input->get('path_to_file');
		$data = array(
				'file_orinal' => $this->input->get('file_orinal'),
				'file_full_path' => $file_full_path,
		);
		force_download(iconv('utf-8', 'euc-kr',$data['file_orinal']), file_get_contents($data['file_full_path']));
	}

	function oauth2callback(){
		require_once FCPATH.'common/assets/google-api-php-client-master/src/Google/autoload.php';
		// Start a session to persist credentials.


		// Create the client object and set the authorization configuration
		// from the client_secrets.json you downloaded from the Developers Console.
		$client = new Google_Client();
		$client->setAuthConfigFile(FCPATH.$this->config->item('ga_json'));
		$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/util/oauth2callback');
		$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
		$client->setAccessType( 'offline' );
		// Handle authorization flow from the server.

		if (! $this->input->get('code')) {
		  $auth_url = $client->createAuthUrl();
		  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
		} else {
		  $client->authenticate($this->input->get('code'));
		 // $_SESSION['access_token'] = $client->getAccessToken();

		  $this->session->set_userdata(array('access_token' => $client->getAccessToken()));
		  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/thdadmin/dashboard';
		  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
	}
	
}
