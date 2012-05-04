<?php
		require_once("class/couchdb.php");
		$couchdbname = "/" . $_GET["cdb"];
		$couchdb_host = $_GET['chost'];
		$couchdb_port = $_GET['cport'];
		$mongodb_cstring = "mongodb://" . $_GET['mhost'] . ":" .  $_GET['mport'];
		$mongodb_dbname = $_GET['mdb'];
		$mongodb_cname = $_GET['mcol'];
		$baza = new CouchDB($couchdb_host, $couchdb_port);
		$alldata = array();
		$i=0;
		if($baza->polacz()) {
			echo "Polaczenie z CouchDb : " . $couchdb_host . ":" . $couchdb_port .  " -powiod³o siê\n\r";
			$pos=false;
			echo "Pobieram rekordy z bazy: " . $couchdbname . "\n\r";
			while(!$pos) {
				$baza->polacz();
				$resp = $baza->odpowiedz("GET", $couchdbname . "/" . $i);
				$pos = strpos($resp, "error");
				$rt = json_decode($resp, true);
				unset($rt["_id"]);
				unset($rt["_rev"]);
				array_push($alldata,$rt);
				$i++;
			}
		
			echo "Pobrano: " . sizeof($alldata) . "rekordów z Bazy CouchDB\n\r"; 
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
		else echo "Problem z polaczeniem z CouchDb";
?>
