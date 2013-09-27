#############################################################################
##                 INSTALLS CLEVERFIGURES IN THE SYSTEM                    ##
#############################################################################


# Make sure only root can run our script
if [[ $EUID -ne 0 ]]; then
  echo "This script must be run as root" 1>&2
  exit 1
fi

# Introduction
echo "
Welcome! This script will install Cleverfigures in your system."
echo "Take in mind that you should have already unzipped the package
that you downloaded and you should be running this script from its
original location."
echo "Please, type some necessary data to continue the installation."

## Sets variables
echo "Installation path: "
read CLEVERFIGURES_INSTALLATION_PATH
echo "Downloaded folder path: "
read CLEVERFIGURES_DOWNLOADED_FOLDER

echo "Mysql command: "
read MYSQL_COMMAND
echo "Mysql user: "
read MYSQLUSER
echo "Mysql password: "
read MYSQLPASSWORD
echo "Mysql server: "
read MYSQLSERVER
echo "Cleverfigures database name (will be created): "
read MYSQLDBNAME

SQLFOLDER='./resources'


## ----------------------------------------------------------------------- ##
##                      DO NOT EDIT BELOW THIS LINE                        ##
## ----------------------------------------------------------------------- ##


## Checks that paths have been set
echo "Checking variables..."
if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH ]; then
  echo "ERROR: You must set Cleverfigures installation path correctly"
  exit 1
fi

if [ ! -d $CLEVERFIGURES_DOWNLOADED_FOLDER ]; then
  echo "ERROR: You must set Cleverfigures package path correctly"
  exit 1
fi

## Check mysql status
echo "Checking mysql binnary..."
hash $MYSQL_COMMAND 2>/dev/null || {
  echo >&2 "ERROR: No pudo ejecutarse Mysql con el comando dado"
  exit 1
}

## Create database
echo "Creating database..."
$MYSQL_COMMAND -u$MYSQLUSER -p$MYSQLPASSWORD < $SQLFOLDER/dbcreate.sql

## Install cleverfigures
echo "Copying files..."
cp -r $CLEVERFIGURES_DOWNLOADED_FOLDER/* $CLEVERFIGURES_INSTALLATION_PATH

echo "Configuring database..."
mv $CLEVERFIGURES_INSTALLATION_PATH/application/config/database.php $CLEVERFIGURES_INSTALLATION_PATH/application/config/database.php.old
bash $SQLFOLDER/databaseconfig.sh $MYSQLSERVER $MYSQLDBNAME $MYSQLUSER $MYSQLPASSWORD $CLEVERFIGURES_INSTALLATION_PATH/application/config/

echo "Creating neccessary folders..."
if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH/application/analysis ]; then
  mkdir $CLEVERFIGURES_INSTALLATION_PATH/application/analysis
fi

if [ ! -d $CLEVERFIGURES_INSTALLATION_PATH/application/csv ]; then
  mkdir $CLEVERFIGURES_INSTALLATION_PATH/application/csv
fi

echo ">> Cleverfigures has been installed successfully <<"
