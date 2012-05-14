<?php
	require_once("class/couchdb.php");
	$file = "../" . $_GET['filename'];
	$alldata = array();
	$couchdb_host = $_GET['chost'];
	$couchdb_port = $_GET['cport'];
	$couchdbname = "/" . $_GET['cdb'];
	$f=0;
	try {
		$handle = fopen($file, "r");
	}
	catch(Exception $e) {
	echo 'gg';
	}

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
			echo "Polaczenie z CouchDb : " . $couchdb_host . ":" . $couchdb_port .  " -powiodło się\n\r";
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
