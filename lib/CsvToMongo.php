<?php
	require_once("config.php");
	$file = "../dane/" . $csvfilename;
	$alldata = array();
	$mongodb_cstring = "mongodb://" . $mongodb_host . ":" .  $mongodb_port;
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
		
			if(sizeof($alldata) > 0) {
				$connection = new Mongo($mongodb_cstring);
				$db = $connection->selectDB($mongodb_dbname);
				$db->selectCollection($mongodb_cname)->drop();
				$db->createCollection($mongodb_cname);
				for($i=0;$i<sizeof($alldata); $i++)
				$db->selectCollection($mongodb_cname)->insert($alldata[$i]);
			}
		echo "Do bazy MongoDb zapisano:" . $i . " rekordow\n\r";

	}
	else {
		echo "nie znaleziono pliku";
		die();
	}

?>