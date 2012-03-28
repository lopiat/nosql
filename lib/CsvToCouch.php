<?php
	require_once("class/couchdb.php");
	require_once("config.php");
	$file = "../dane/" . $csvfilename;
	$alldata = array();
	$couchdbname = "/" . $couchdb_dbname;
	$f=0;
	$handle = fopen($file, "r");

	if($handle !== FALSE) {
		while (($data = fgetcsv($handle, 2000, ";")) !== FALSE) {
			$arr = array();
			if($f==0) {
				$fields = $data;
				$f++;
			}
			else {
			for ($i=0; $i < sizeof($fields); $i++) {
				$arr[$fields[$i]]=$data[$i];
			}
			array_push($alldata, $arr);
		}
		}
		echo "Przekonwertowano : " . sizeof($alldata) . " linijek danych do formatu json\n\r";
		fclose($handle);
		$baza = new CouchDB($couchdb_host, $couchdb_port);
		if($baza->polacz()) {
			echo "Polaczenie z CouchDb : " . $couchdb_host . ":" . $couchdb_port .  " -powiod³o siê\n\r";
			$resp = $baza->odpowiedz("PUT", $couchdbname);
			$pos = strpos($resp, "error");
			if($pos) {
				echo "Nie mozna utworzyc bazy: " . $couchdbname ." baza prawdopodobnie istnieje\n\r";
				echo $resp;
				die();
			}
			echo "Zapisuje dane json do bazy: " . $couchdbname . "\n\r";
			$baza->polacz();
			for($i=0;$i<sizeof($alldata);$i++) {
				$baza->polacz();
				$resp = $baza->odpowiedz("PUT", $couchdbname . "/" . $i, json_encode($alldata[$i]));
				$pos = strpos($resp, "error");
				if($pos) {
					echo "Nie mozna dodac do bazy";
					echo $resp;
					die();
				}
		}
		echo "Do bazy CouchDb zapisano:" . $i . " rekordow\n\r";
		}
		else {
			echo "Brak polaczenia z CouchDB";
		}
	}
	else {
		echo "nie znaleziono pliku";
		die();
	}

?>