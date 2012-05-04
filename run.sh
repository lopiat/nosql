#!/bin/bash

csvtocouch() {
if [ "$#" -lt 4 ]
then
echo -e 'Zle wywowolanie\nPrawidlowe: ./run.sh m1 nazwa_pliku couch_host couch_port couch_db\nPrzyklad: ./run.sh m1 imiona.csv localhost 5984 imiona'  
else
export REDIRECT_STATUS=true
export SCRIPT_FILENAME=lib/CsvToCouch.php
export REQUEST_METHOD=GET
export QUERY_STRING="filename=$1&chost=$2&cport=$3&cdb=$4"
php.fcgi
fi
}

csvtomongo() {
if [ "$#" -lt 5 ]
then
echo -e 'Zle wywowolanie\nPrawidlowe: ./run.sh m2 nazwa_pliku mongo_host mongo_port mongo_db mongo_col\nPrzyklad: ./run.sh m2 imiona.csv localhost 27017 test imiona'  
else
export REDIRECT_STATUS=true
export SCRIPT_FILENAME=lib/CsvToMongo.php
export REQUEST_METHOD=GET
export QUERY_STRING="filename=$1&mhost=$2&mport=$3&mdb=$4&mcol=$5"
php.fcgi
fi
}

zlewywolanie() {
echo -e ' Wystapil blad\n Mozliwe wywolania:'
echo './run.sh m1 - konwertuje dane z pliku imiona.csv i zapisuje w CouchDB'
echo './run.sh m2 - konwertuje dane z pliku imiona.csv i zapisuje w MongoDB'
echo './run.sh m3 - pobiera dane z bazy CouchDB i zapisuje do MongoDB'
echo './run.sh m4 - pobiera dane z bazy MongoDB i zapisuje do CouchDB'
}

couchtomongo() {
}

if [ "$#" -lt 1 ]
then
zlewywolanie
else
case $1 in 
	"m1") csvtocouch $2 $3 $4 $5;;
	"m2") csvtomongo $2 $3 $4 $5 $6;;
	#"m3") couchtomongo $2 $3 $4;;
	#"m4") mongotocouch $2 $2 $4;;
	*) zlewywolanie;;
esac

if [ $1 == 'm122' ] 
then
if [ "$#" -lt 4 ]
then
echo -e 'Zle wywowolanie\nPrawidlowe: ./run.sh m1 nazwa_pliku couch_host couch_port\nPrzyklad: ./run.sh m1 imiona.csv localhost 5984'
else
echo ok
#php.fcgi lib/CsvToCouch.php
fi
elif [ $1 == 'm22' ]
then
php.fcgi lib/CsvToMongo.php
elif [ $1 == '--show-config' ]
then
case $2 in
	"kot") echo swinia;;
esac
echo 'dupa'
elif [ $1 == 'm3' ]
then
php.fcgi lib/CouchToMongo.php
elif [ $1 == 'm4' ]
then
php.fcgi lib/MongoToCouch.php
else echo ''
fi
fi