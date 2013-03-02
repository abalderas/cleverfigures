<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// FICHERO CON OPCIONES DE CONFIGURACIÓN DE ASSESSMEDIAWIKI

// Nombre de la BD de MediaWiki
$config["database_mw"] = "wiki";

// Nombre de usuario de la BD de MediaWiki
$config["username_mw"] = "root";

// Contraseña de la BD de MediaWiki
$config["password_mw"] = "Ornitorrinco1?!";

// Cuando modo_desarrollo == TRUE, se puede hacer login con
// cualquier nombre de usuario sin importar la contraseña
// IMPORTANTE: DESACTIVAR ANTES DE IR A PRODUCCIÓN
$config["modo_desarrollo"] = TRUE;

// ID del usuario correspondiente al profesor/revisor
$config["usuarios_admin"] = array(1, 2);
