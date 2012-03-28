#!/bin/bash

if [ "$#" -lt 1 ]
then
echo 'Mozliwe wywolania:'
echo './run.sh m1 - konwertuje dane z pliku imiona.csv i zapisuje w CouchDB'
echo './run.sh m2 - konwertuje dane z pliku imiona.csv i zapisuje w MongoDB'
echo './run.sh m3 - pobiera dane z bazy CouchDB i zapisuje do MongoDB'
echo './run.sh m4 - pobiera dane z bazy MongoDB i zapisuje do CouchDB'
echo ''
echo 'Przed wywolaniem skryptu nalezy skofigurowac plik config.php zgodnie z Readmy'
echo ''
else
if [ $1 == 'm1' ] 
then
php.fcgi lib/CsvToCouch.php
elif [ $1 == 'm2' ]
then
php.fcgi lib/CsvToMongo.php
elif [ $1 == 'm3' ]
then
php.fcgi lib/CouchToMongo.php
elif [ $1 == 'm4' ]
then
php.fcgi lib/MongoToCouch.php
else
echo 'Zly parametr mozliwe opcje to:'
echo './run.sh m1 - konwertuje dane z pliku imiona.csv i zapisuje w CouchDB'
echo './run.sh m2 - konwertuje dane z pliku imiona.csv i zapisuje w MongoDB'
echo './run.sh m3 - pobiera dane z bazy CouchDB i zapisuje do MongoDB'
echo './run.sh m4 - pobiera dane z bazy MongoDB i zapisuje do CouchDB'
echo ''
echo 'Przed wywolaniem skryptu nalezy skofigurowac plik config.php zgodnie z Readmy'
echo ''
fi
fi
