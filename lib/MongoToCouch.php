<?php
	require_once("class/couchdb.php");
	$couchdbname = "/" . $_GET["cdb"];
	$couchdb_host = $_GET['chost'];
	$couchdb_port = $_GET['cport'];
	$mongodb_cstring = "mongodb://" . $_GET['mhost'] . ":" .  $_GET['mport'];
	$mongodb_dbname = $_GET['mdb'];
	$mongodb_cname = $_GET['mcol'];
	$alldata = array();
	try {
		$connection = new Mongo($mongodb_cstring);
		if($connection !=null) {
	$connection = new Mongo($mongodb_cstring);
	echo "Polaczono z MongoDB " . $mongodb_cstring . "\n\r";
	$db = $connection->selectDB($mongodb_dbname);
	$colection = $db->selectCollection($mongodb_cname);
	$cursor = $colection->find();
	echo "Pobieram rekordy z bazy: " . $mongo_dbname . "."  . $mongodb_cname . "\n\r";
	foreach ($cursor as $obj) {
		unset($obj["_id"]);
		array_push($alldata, $obj);
	}
	echo "Pobrano: " . sizeof($alldata) . "rekordów z Bazy MongoDB\n\r"; 
	$connection->close();			
	if(sizeof($alldata) > 0) {
		$baza = new CouchDB($couchdb_host, $couchdb_port);
		if($baza->polacz()) {
			echo "Polaczenie z CouchDb : " . $couchdb_host . ":" . $couchdb_port .  " -powiodło się\n\r";
			$resp = $baza->odpowiedz("PUT", $couchdbname);
			$pos = strpos($resp, "error");
			if($pos) {
				echo "Nie mozna utworzyc bazy:" . $couchdbname ."\n\r";
				echo $resp;
				die();
			}
			$baza->polacz();
			echo "Zapisuje rekordy do bazy: " . $couchdbname . "\n\r";
			for($i=0;$i<sizeof($alldata);$i++) {
				$baza->polacz();
				$resp = $baza->odpowiedz("PUT", $couchdbname . "/" . $i, json_encode($alldata[$i]));
				$pos = strpos($resp, "error");
				if($pos) {
					echo "Nie mozna dodac do bazy MongoDB";
					echo $resp;
					die();
					}
			}
			echo "Do bazy CouchDb zapisano:" . $i . " rekordow\n\r";
	   }
		else echo "Problem z polaczeniem z CouchDb";
	}
	}
	}
	catch(Exception $e) {
		echo "MongoDB blad zapisu: " .$e->getMessage();
	}


?>
