<?php 
// Load the Google API PHP Client Library.
require_once FCPATH.'common/assets/google-api-php-client-master/src/Google/autoload.php';

class THD_Analytics {
	private $client; 
	function __construct() {	
		$this->CI =& get_instance();
		$this->CI->load->library(array('session','alert'));
		$this->client = new Google_Client();
		$this->client->setAuthConfigFile(FCPATH.$this->CI->config->item('ga_json'));
		$this->client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
		$this->client->setIncludeGrantedScopes(true);
		$this->client->setAccessType("offline");
			
	}

	function revoke(){
		$this->client->revokeToken();
	}

	function result(){
		// Create the client object and set the authorization configuration
		// from the client_secretes.json you downloaded from the developer console.
		
		
		// If the user has already authorized this app then get an access token
		// else redirect to ask the user to authorize access to Google Analytics.
		if ($this->CI->session->userdata('access_token')) {
		  try{
			  // Set the access token on the client.
			  $this->client->setAccessToken($this->CI->session->userdata('access_token'));

			  // Create an authorized analytics service object.
			  $analytics = new Google_Service_Analytics($this->client);

			  // Get the first view (profile) id for the authorized user.
			  //$profile = $this->getFirstProfileId($analytics);
			  $profile = $this->CI->config->item('ga_ids');	
			  // Get the results from the Core Reporting API and print the results.
			  $results = $this->getResults($analytics, $profile);
			  
			  //print_r($results);
			  //$this->printResults($results);
				$data = array('status' => 1, 'result'=>$results);
		  }catch(Exception $e){ 
			  $this->CI->session->set_userdata(array('access_token' =>null));
			  $this->revoke();
			  $this->CI->alert->jalert($e->getMessage(), base_url('/thdadmin/dashboard'));
		  }
		} else {
		  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/util/oauth2callback';
		  $data = array('status' => 0, 'result'=>filter_var($redirect_uri, FILTER_SANITIZE_URL));
		  //header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
		return $data;
	}


	function getFirstprofileId(&$analytics) {
	  // Get the user's first view (profile) ID.

	  // Get the list of accounts for the authorized user.
	  $accounts = $analytics->management_accounts->listManagementAccounts();

	  if (count($accounts->getItems()) > 0) {
		$items = $accounts->getItems();
		$firstAccountId = $items[0]->getId();

		// Get the list of properties for the authorized user.
		$properties = $analytics->management_webproperties
			->listManagementWebproperties($firstAccountId);

		if (count($properties->getItems()) > 0) {
		  $items = $properties->getItems();
		  $firstPropertyId = $items[0]->getId();

		  // Get the list of views (profiles) for the authorized user.
		  $profiles = $analytics->management_profiles
			  ->listManagementProfiles($firstAccountId, $firstPropertyId);

		  if (count($profiles->getItems()) > 0) {
			$items = $profiles->getItems();

			// Return the first view (profile) ID.
			return $items[0]->getId();

		  } else {
			throw new Exception('No views (profiles) found for this user.');
		  }
		} else {
		  throw new Exception('No properties found for this user.');
		}
	  } else {
		throw new Exception('No accounts found for this user.');
	  }
	}

	function getResults(&$analytics, $profileId) {
	  // Calls the Core Reporting API and queries for the number of sessions
	  // for the last seven days.
	  $optional = array('dimensions' =>'ga:yearMonth,ga:day');
	  return $analytics->data_ga->get(
		  'ga:' . $profileId,
		  '30daysAgo',
		  'today',
		  'ga:sessions', $optional);
	}

	function printResults(&$results) {
	  // Parses the response from the Core Reporting API and prints
	  // the profile name and total sessions.
	  if (count($results->getRows()) > 0) {

		// Get the profile name.
		$profileName = $results->getProfileInfo()->getProfileName();

		// Get the entry for the first entry in the first row.
		$rows = $results->getRows();
		$sessions = $rows[0][0];

		// Print the results.
		print "<p>First view (profile) found: $profileName</p>";
		print "<p>Total sessions: $sessions</p>";
	  } else {
		print "<p>No results found.</p>";
	  }
	}
}

?>
