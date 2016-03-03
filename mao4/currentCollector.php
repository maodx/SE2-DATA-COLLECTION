<?php
	include_once 'classes/dbConnection.php';
	include_once 'classes/query.php';
	include_once 'classes/stockRetriever.php';
	include_once 'classes/stockExtractor.php';
	date_default_timezone_set("America/New_York"); 
	//ini_set("error_reporting","E_ALL & ~E_NOTICE");
	//instantiate necessary objects
	$dbConnection = new dbConnection();
	$query = new query();
	$stockRetriever = new stockRetriever();
	$stockExtractor = new stockExtractor();
	
	//conect to database
	$dbConnection->connect();
	
	//get stockID and ticker of all stocks
	$dbConnection->prepare($query->get_stockID_and_ticker());
	$results = $dbConnection->resultset();
	//disconnect from database
	$dbConnection->disconnect();
	
	//for each stocks
	foreach ($results as $stock) {
		//echo $stock['Ticker'];//
		//retrieve current price
		$document = $stockRetriever->retrieveCurrentPrice($stock['Ticker']);	
		//echo $currentprices['StockID'];//
		//extract current price
		$stockExtractor->extractMyCurrentPrice($document, $stock['StockID']);
	}

?>