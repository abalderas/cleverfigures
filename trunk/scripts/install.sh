#############################################################################
##                 INSTALLS CLEVERFIGURES IN THE SYSTEM                    ##
#############################################################################


## Sets paths
CLEVERFIGURES_INSTALLATION_PATH=
CLEVERFIGURES_DOWNLOADED_FOLDER=

## Sets mysql variables
MYSQL_COMMAND=
MYSQLUSER=
MYSQLPASSWORD=
MYSQLSERVER=
MYSQLDBNAME=
SQLFOLDER=


## ----------------------------------------------------------------------- ##
##                      DO NOT EDIT BELOW THIS LINE                        ##
## ----------------------------------------------------------------------- ##


## Checks that paths have been set
echo "Checking neccessary variables..."
if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH ]; then
  echo "ERROR: You must set Cleverfigures installation path correctly"
  exit 1
fi

if [ ! -d $CLEVERFIGURES_DOWNLOADED_FOLDER ]; then
  echo "ERROR: You must set Cleverfigures package path correctly"
  exit 1
fi
echo "OK\n"

## Check mysql status
echo "Checking mysql binnary..."
hash $MYSQL_COMMAND 2>/dev/null || {
  echo >&2 "ERROR: No pudo ejecutarse Mysql con el comando dado"
  exit 1
}
echo "OK\n"

## Create database
echo "Creating database..."
mysql -u$MYSQLUSER -p$MYSQLPASSWORD < $SQLFOLDER/dbcreate.sql
echo "OK\n"

## Install cleverfigures
echo "Copying files..."
cp $CLEVERFIGURES_DOWNLOADED_FOLDER $CLEVERFIGURES_INSTALLATION_PATH
echo "OK\n"

echo "Configuring database..."
mv $CLEVERFIGURES_INSTALLATION_PATH/application/config/database.php $CLEVERFIGURES_INSTALLATION_PATH/application/config/database.php.old
bash $SQLFOLDER/databaseconfig.sh $MYSQLSERVER $MYSQLDBNAME $MYSQLUSER $MYSQLPASSWORD $CLEVERFIGURES_INSTALLATION_PATH/application/config/
echo "OK\n"

echo "Creating neccessary folders..."
if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH/application/analysis ]; then
  mkdir $CLEVERFIGURES_INSTALLATION_PATH/application/analysis
fi

if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH/application/csv ]; then
  mkdir $CLEVERFIGURES_INSTALLATION_PATH/application/csv
fi
echo "OK\n"

echo ">> Cleverfigures has been installed successfully <<"
