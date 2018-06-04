<?php
/**
 * Codeigniter Library
 * Google Drive Generate Direct Download Link
 * @author MuhBayu <bnugraha00@gmail.com>
 *
 */
class Gdirect
{
	public function generateLink($DriveID, $direct=FALSE) {
		if(filter_var($DriveID, FILTER_VALIDATE_URL)) $DriveID = $this->get_driveid_from_url($DriveID);
		$ch = curl_init("https://drive.google.com/uc?id=$DriveID&authuser=0&export=download");
		curl_setopt_array($ch, array(
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => [],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => 'gzip,deflate',
			CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
			CURLOPT_HTTPHEADER => [
				'accept-encoding: gzip, deflate, br',
				'content-length: 0',
				'content-type: application/x-www-form-urlencoded;charset=UTF-8',
				'origin: https://drive.google.com',
				'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36',
				'x-client-data: CKG1yQEIkbbJAQiitskBCMS2yQEIqZ3KAQioo8oBGLeYygE=',
				'x-drive-first-party: DriveWebUi',
				'x-json-requested: true'
			]
		));
		$response = curl_exec($ch);
		$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($response_code == '200') { // Jika response status OK
			$object = json_decode(str_replace(')]}\'', '', $response));
			if(isset($object->downloadUrl)) {
				if($direct) return header("Location:$object->downloadUrl");
				return $object->downloadUrl;
			} 
		} else {
			return $response_code;
		}
	}
	public function get_driveid_from_url($url) {
		return (strpos($url, '?id=') > 0) ? Self::parse_param('id', $url) : explode('/', $url)[5];
	}
	protected function parse_param($get_param, $url) {
		$query_str = parse_url($url, PHP_URL_QUERY);
		parse_str($query_str, $query_params);
		if(isset($query_params[$get_param])) {
			return $query_params[$get_param];
		} else {
			return false;
		}
	}
}

