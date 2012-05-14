Repozytorium zawiera zbiór skryptów php umożliwiających:

Przekonwertowanie danych z formatu CSV do JSON i zapisu w bazie CouchDB

Przekonwertowanie danych z formatu CSV do JSON i zapisu w bazie MongoDB

Przeniesienie bazy z CouchDB do MongoDB

Przeniesienie bazy z MongoDB do CouchDB

Instalacja i uruchomienie Sigma
-------------------------------------------------------------------------------------------------------------------
Wymagania: MongoDB  i CouchDB

Instalacja:
 
	git clone https://github.com/lopiat/nosql.git

	cd nosql

	chmod +x run.sh

	uruchomić bazy 

Mozliwe wywolania:

1. Konwersja danych z pliku csv i zapis w CouchDB

        ./run.sh m1 nazwa_pliku host port baza
		./run.sh m1 dane\imiona.csv localhost 5984 imiona 

2. Konwersja danych z pliku csv i zapis w MongoDB

        ./run.sh m2 nazwa_pliku host port baza kolekcja
		./run.sh m1 dane\imiona.csv localhost 27017 test imiona

3. Pobiera dane z bazy CouchDB i zapisuje w MongoDB

        ./run.sh m3 couch_host couch_port couch_db mongo_host mongo_port mongo_db mongo_col
        ./run.sh m3 localhost 5984 imiona localhost 27017 test imiona

4. Pobiera dane z bazy MongoDB i zapisuje w CouchDB

        ./run.sh m4 couch_host couch_port couch_db mongo_host mongo_port mongo_db mongo_col
        ./run.sh m4 localhost 5984 imiona localhost 27017 test imiona

Instalacja i uruchomienie poza Sigma
-------------------------------------------------------------------------------------------------------------------
Wymagania: MongoDB,CouchDB,php5,php-cgi

Instalacja:

	git clone https://github.com/lopiat/nosql.

	cd nosql

	chmod +x run2.sh

	uruchomić bazy 

Mozliwe wywolania:

1. Konwersja danych z pliku csv i zapis w CouchDB

        ./run2.sh m1 nazwa_pliku host port baza
		./run2.sh m1 dane\imiona.csv localhost 5984 imiona 

2. Konwersja danych z pliku csv i zapis w MongoDB

        ./run2.sh m2 nazwa_pliku host port baza kolekcja
		./run2.sh m1 dane\imiona.csv localhost 27017 test imiona

3. Pobiera dane z bazy CouchDB i zapisuje w MongoDB

        ./run2.sh m3 couch_host couch_port couch_db mongo_host mongo_port mongo_db mongo_col
        ./run2.sh m3 localhost 5984 imiona localhost 27017 test imiona

4. Pobiera dane z bazy MongoDB i zapisuje w CouchDB

        ./run2.sh m4 couch_host couch_port couch_db mongo_host mongo_port mongo_db mongo_col
        ./run2.sh m4 localhost 5984 imiona localhost 27017 test imiona

W razie ostrzeżeń php należy przekopiować extension/mongo.so do lokalizacji wskazywanej przez zmieną php extension_dir i usunąć pliki php.ini

couchdb-map-reduce.js
-----------------------------------------------------------------------------------------------------------------------------
Funkcje Map-Reduce dla CouchDB i bazy imiona.

Przyklady

Ilość imion żeńskich w bazie

		http://localhost:5984/imiona/_design/app/_view/plec?key="K"
Ilość imion męskich w bazie

		http://localhost:5984/imiona/_design/app/_view/plec?key="M"
Ilość imion w bazie majacych 4 sylaby

		http://localhost:5984/imiona/_design/app/_view/sylaba?key="4"

Ilość długość imienia

		http://localhost:5984/imiona/_design/app/_view/dlugoscimienia?key="Marzena"

Suma sylab w podanych imionach

		http://localhost:5984/imiona/_design/app/_view/iloscsylab?startkey="Abadon"&endkey="Celina"


mongo-map-reduce.js
-----------------------------------------------------------------------------------------------------------------------------
Funkcje Map-Reduce dla MongoDB i bazy imiona

Ilość imion żeńskich w bazie

		res = db.imiona.mapReduce(map1, reduce1,{out: { inline : 1}});

Ilość imion męskich w bazie

		res = db.imiona.mapReduce(map2, reduce1,{out: { inline : 1}});

Średnia ilość sylab w imionach

		res = db.imiona.mapReduce(map5, reduce2,{out: { inline : 1}});

Ilość imion zawierających litere o

		res = db.imiona.mapReduce(map4, reduce1,{out: { inline : 1}});

Suma sylab w wszystkich imionach

		res = db.imiona.mapReduce(map5, reduce1,{out: { inline : 1}});


katalog lib
-----------------------------------------------------------------------------------------------------------------------------

CsvToCouch.php - konwertuje dane z formatu.csv to formatu json i zapisuje w bazie CouchDB.

MongoToCouch.php - konwertuje dane z formatu.csv to formatu json i zapisuje w bazie MongoDB.

CouchToMongo.php - pobiera baze z CouchDB i zapisuje w MongoDB

MongoToCouch.php - pobiera baze z MongoDB i zapisuje w CouchDB

class\couchdb.php - klasa do połaczenia i wykonywania zapytań na bazie Couchdb

extension - rozszerzenie mongo.so do obsługi MongoDB + rozszerzenia wymagane przez sigme

(do kontroli nad bazą mongoDB wymagane jest rozszerzenie mongo.so
jest ono w katalagu extension z odpowiednio skonfigurowanym php.ini
serwer sigma po zmianie w php.ini zmiennej extension_dir zgłaszał ostrzezenia o braku innych bibliotek
dlatego zostaly one rowniez dodane do repozytorium)