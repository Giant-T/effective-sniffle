<?php 

// Constante du mode de l'application
// dev : variables utilisées en local
// prod : pour le déploiement de l'api en production
define("MODE", "dev");

switch (MODE) {
    case "dev":
        // Configuration BD en local
        $_ENV['hst'] = 'localhost';
        $_ENV['username'] = 'root';
        $_ENV['database'] = 'libapi';
        $_ENV['password'] = 'mysql';
        break;

    case "prod":
        // Configuration BD pour Heroku
        $_ENV['host'] = 'us-cdbr-east-05.cleardb.net';
        $_ENV['username'] = 'b9eab5defceaad';
        $_ENV['database'] = 'heroku_8e44820f6610585';
        $_ENV['password'] = 'ad963dc4';
        break;
};

