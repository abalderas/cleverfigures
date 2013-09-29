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
CLEVERFIGURES_INSTALLATION_PATH='/opt/lampp/htdocs/cleverfigures-prueba-scripts'
echo "Downloaded folder path: "
CLEVERFIGURES_DOWNLOADED_FOLDER='/opt/lampp/htdocs/cleverfigures/trunk'

echo "Mysql command: "
MYSQL_COMMAND='/opt/lampp/bin/mysql'
echo "Mysql user: "
MYSQLUSER='root'
echo "Mysql password: "
MYSQLPASSWORD='Ornitorrinco1?!'
echo "Mysql server: "
MYSQLSERVER='localhost'
echo "Cleverfigures database name (will be created): "
MYSQLDBNAME='cleverfigures'

echo "Cleverfigures administrator name: "
CLEVADMIN='sirfocus'
echo "Cleverfigures administrator password: "
CLEVADMINPASS='ornitorrinco'
echo "Cleverfigures administrator email: "
CLEVADMINMAIL='prueba@prueba.com'

SQLFOLDER='/opt/lampp/htdocs/cleverfigures/trunk/scripts/resources'


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

## Create first user
$MYSQL_COMMAND -u$MYSQLUSER -p$MYSQLPASSWORD -e "
use $MYSQLDBNAME;
INSERT INTO user
  (user_username, user_password, user_last_session, user_realname, user_email, user_language, user_is_admin, user_high_contrast)
  VALUES ('$CLEVADMIN', '$(echo -n $CLEVADMINPASS | md5sum)', '$(date +%s)', 'Alvaro Almagro', 'prueba@prueba.com', 'english', true, false)"

## Install cleverfigures
echo "Copying files..."
cp -ru $CLEVERFIGURES_DOWNLOADED_FOLDER/. $CLEVERFIGURES_INSTALLATION_PATH

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
