<?php


class API {

	public $response;
	public $json;

public function __construct($category = null){
	if($category == null){
		//do nothing
	} else {

	//start cURL
	$curl = curl_init();
	
	//connecting API and sorted by categoty
	curl_setopt($curl, CURLOPT_URL, "https://newsapi.org/v2/top-headlines?country=us&category={$category}&apiKey=01497af158bb4036b4b4bf74be3633ec");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	//get response
	$response = curl_exec($curl);
	$err = curl_error($curl);


	//return json decoded data
	return json_decode($response,true);

	curl_close($curl);
	}

}



public function getAllCategories($category){
	//start cURL
	$curl = curl_init();
	

	//connecting API and sorted by categoty
	curl_setopt($curl, CURLOPT_URL, "https://newsapi.org/v2/top-headlines?country=us&category={$category}&apiKey=01497af158bb4036b4b4bf74be3633ec");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	//get response
	$response = curl_exec($curl);
	$err = curl_error($curl);


	//return json decoded data
	return json_decode($response,true);

	curl_close($curl);

}


}