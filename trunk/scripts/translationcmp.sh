#!/bin/bash

## Compares translation files to look for differences to the default one
## This script should always be allocated in the scripts/ folder

#Sets default language to compare files and languages folder
DEFAULT_LANGUAGE='english'
LANGUAGE_FOLDER='../application/language/'
LANGUAGE_FILE='voc_lang.php'

## Gets languages from the default folder
LANGUAGES=$(ls $LANGUAGE_FOLDER)

## Removes default language from the languages list
DIRECTORIES=`echo $LANGUAGES | sed "s/\b$DEFAULT_LANGUAGE\b//g"`

## Compares languages files
for LANGUAGE_DIRECTORY in $DIRECTORIES
do
  echo ""
  echo "--------------------------------------------------------------"
  echo "COMPARING $LANGUAGE_DIRECTORY WITH $DEFAULT_LANGUAGE..."
  diff <(cat $LANGUAGE_FOLDER/$LANGUAGE_DIRECTORY/$LANGUAGE_FILE | grep -e .*= -o) <(cat $LANGUAGE_FOLDER/$DEFAULT_LANGUAGE/$LANGUAGE_FILE | grep -e .*= -o)
  echo "--------------------------------------------------------------"
  echo ""
done
