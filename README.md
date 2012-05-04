Repozytorium zawiera zbiór skryptów php umożliwiających:

Przekonwertowanie danych z formatu CSV do JSON i zapisu w bazie CouchDB

Przekonwertowanie danych z formatu CSV do JSON i zapisu w bazie MongoDB

Przeniesienie bazy z CouchDB do MongoDB

Przeniesienie bazy z MongoDB do CouchDB

Skrypty sa przystosowane do działania na sigmie

Wymagane dla prawidłowego działania:
--------------------------------------------------------------------------------------------------------------------
php.fcgi -zainstalowany na sigmie (na sigmie brak polecenia php)

mongo.so -rozszerzenie dla bazy Mongo 


run.sh
-------------------------------------------------------------------------------------------------------------------
 Mozliwe wywolania:
1. Konwersja danych z pliku csv i zapis w CouchDB

        /run.sh m1 nazwa_pliku host port baza (dane\imiona.csv,localhost,5984,imiona)

2. Konwersja danych z pliku csv i zapis w MongoDB

        /run.sh m2 nazwa_pliku host port baza kolekcja (dane\imiona.csv,localhost,27017,test,imiona)

3. Pobiera dane z bazy CouchDB i zapisuje w MongoDB

        ./run.sh m3 couch_host couch_port couch_db mongo_host mongo_port mongo_db mongo_col
        ./run.sh m3 localhost 5984 imiona localhost 27017 test imiona

4. Pobiera dane z bazy MongoDB i zapisuje w CouchDB

        ./run.sh m4 couch_host couch_port couch_db mongo_host mongo_port mongo_db mongo_col
        ./run.sh m4 localhost 5984 imiona localhost 27017 test imiona

Inne
-----------------------------------------------------------------------------------------------------------------------------
do kontroli nad bazą mongoDB wymagane jest rozszerzenie mongo.so
jest ono w katalagu extension z odpowiednio skonfigurowanym php.ini
serwer sigma po zmianie w php.ini zmiennej extension_dir zgłaszał ostrzezenia o braku innych bibliotek
dlatego zostaly one rowniez dodane do repozytorium