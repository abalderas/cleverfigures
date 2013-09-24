## Installs cleverfigures in the system

## Sets variables
CLEVERFIGURES_INSTALLATION_PATH=
CLEVERFIGURES_DOWNLOADED_FOLDER=

MYSQL_COMMAND=
MYSQLUSER=
MYSQLPASSWORD=
MYSQLSERVER=
MYSQLDBNAME=
SQLFOLDER=


## Check mysql status
echo "Checking mysql binnary..."
hash $MYSQL_COMMAND 2>/dev/null || { echo >&2 "No pudo ejecutarse Mysql con el comando dado"; exit 1; }
echo "OK\n"

## Create database
echo "Creating database..."
mysql -u$MYSQLUSER -p$MYSQLPASSWORD < $SQLFOLDER/dbcreate.sql
echo "OK\n"

## Install cleverfigures
echo "Copying files..."
cp $CLEVERFIGURES_DOWNLOADED_FOLDER $CLEVERFIGURES_INSTALLATION_PATH
mv $CLEVERFIGURES_INSTALLATION_PATH/application/config/database.php $CLEVERFIGURES_INSTALLATION_PATH/application/config/database.php.old
echo "OK\n"

echo "Configuring database..."
bash $SQLFOLDER/databaseconfig.sh $MYSQLSERVER $MYSQLDBNAME $MYSQLUSER $MYSQLPASSWORD
echo "OK\n"

echo "Creating neccessary files..."

if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH/application/analysis ]; then
  mkdir $CLEVERFIGURES_INSTALLATION_PATH/application/analysis
fi
if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH/application/csv ]; then
  mkdir $CLEVERFIGURES_INSTALLATION_PATH/application/csv
fi
echo "OK\n"

echo ">> Cleverfigures has been installed <<"
