Repozytorium zawiera zbiór skryptów php umożliwiających:

Przekonwertowanie danych z formatu CSV do JSON i zapisu w bazie CouchDB

Przekonwertowanie danych z formatu CSV do JSON i zapisu w bazie MongoDB

Przeniesienie bazy z CouchDB do MongoDB

Przeniesienie bazy z MongoDB do CouchDB

Skrypty sa przystosowane do działania na sigmie

Wymagane dla prawidłowego działania:
--------------------------------------------------------------------------------------------------------------------
php.fcgi -zainstalowany na sigmie (brak polecenia php)

mongo.so -rozszerzenie dla bazy Mongo 

konfiguracja config.php - opisane poniżej

Uruchamianie:
-------------------------------------------------------------------------------------------------------------------
./run.sh m1 - konwertuje dane z pliku imiona.csv i zapisuje w CouchDB

./run.sh m2 - konwertuje dane z pliku imiona.csv i zapisuje w MongoDB

./run.sh m3 - pobiera dane z bazy CouchDB i zapisuje do MongoDB

./run.sh m4 - pobiera dane z bazy MongoDB i zapisuje do CouchDB


Przed uruchomieniem skryptu należy odpowiednio skonfigurować plik config.php (lib\config.php)

Konfiguracja pliku config.php
----------------------------------------------------------------------------------------------------------------------------
Należy ustawić kilka zmiennych:

$csvfilename = nazwa pliku

$couchdb_host = host dla couchDB

$couchdb_port = port dla couchDB

$couchdb_dbname = nazwa bazy w couchdb jaka zostanie utworzona lub z jakiej zostana pobrane dane
$mongodb_host = host dla mongoDB

$mongodb_port = port dla mongoDB 

$mongodb_dbname = nazwa bazy mongo jaka zostanie utworzona lub z jakiej zostana pobrane dane

$mongodb_cname = nazwa kolekcji mongo jaka zostanie utworzona lub z jakiej zostana pobrane dane

przyklad:

$csvfilename = "imiona.csv";

$couchdb_host = "sigma.ug.edu.pl";

$couchdb_port = "41139";

$couchdb_dbname = "imiona";

$mongodb_cstring = "mongodb://localhost:21139";

$mongodb_host = "localhost";

$mongodb_port = "21139"; 

$mongodb_dbname = "nosql";

$mongodb_cname = "imiona";

Inne
-----------------------------------------------------------------------------------------------------------------------------
do kontroli nad bazą mongoDB wymagane jest rozszerzenie mongo.so
jest ono w katalagu extension z odpowiednio skonfigurowanym php.ini
serwer sigma po zmianie w php.ini zmiennej extension_dir zgłaszał ostrzezenia o braku innych bibliotek
dlatego zostaly one rowniez dodane do repozytorium