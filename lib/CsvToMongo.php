<?php
	$file = "../" . $_GET['filename'];
	$alldata = array();
	$mongodb_cstring = "mongodb://" . $_GET['mhost'] . ":" .  $_GET['mport'];
	$f=0;
	$mongodb_dbname = $_GET['mdb'];
	$mongodb_cname = $_GET['mcol'];
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
				try {
				$connection = new Mongo($mongodb_cstring);
				if($connection !=null) {
				$db = $connection->selectDB($mongodb_dbname);
				$db->selectCollection($mongodb_cname)->drop();
				$db->createCollection($mongodb_cname);
				for($i=0;$i<sizeof($alldata); $i++)
				$db->selectCollection($mongodb_cname)->insert($alldata[$i]);
				echo "Do bazy MongoDb zapisano:" . $i . " rekordow\n\r";
				}
				}
				catch(Exception $e) {
					echo "Blad zapisu: " .$e->getMessage();
				}

			}
		

	}
	else {
		echo "nie znaleziono pliku";
		die();
	}

?>