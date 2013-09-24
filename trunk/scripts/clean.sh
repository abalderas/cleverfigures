#!/bin/bash

## Cleans system leaving it as clear as when initially installed
## This script should always be allocated in ../scripts/

## Database connection credentials
MYSQLUSER=
MYSQLPASSWORD=

## Sets content folders
ANALYSIS_FOLDER='../analisis'
CSV_FOLDER='../csv'
SQLFOLDER='./sql'

## Deletes created analysis files
echo ">> Deleting created analysis files..."
rm -r $ANALYSIS_FOLDER/.+
rm -r $CSV_FOLDER/.+

## Empties database
echo ">> Deleting database..."
mysql -u$MYSQLUSER -p$MYSQLPASSWORD < $SQLFOLDER/dbdelete.sql

## Recreates database
echo ">> Creating new empty database..."
mysql -u$MYSQLUSER -p$MYSQLPASSWORD < $SQLFOLDER/dbcreate.sql

echo ">> Done"
