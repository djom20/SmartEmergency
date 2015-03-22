<?php
    $config = Config::singleton();
    $config->set('controllersFolder', 'Controllers/');
    $config->set('modelsFolder', 'Models/');
    $config->set('xmlFolder', 'Models/xml/');
    $config->set('wsFolder', 'Models/services/');
    $config->set('viewsFolder', 'Views/');
    $config->set('templatesFolder', 'Templates/');
    
    $config->set('Template', 'default.php');
    $config->set('Environment', 'production');

    switch ($config->get('Environment')) {
        case 'test':
            $config->set('BaseUrl', 'http://localhost/api');
            $config->set('driver', 'mysql');
            $config->set('dbhost', 'localhost');
            $config->set('dbname', 'altiviao_smartemergency');
            $config->set('dbuser', 'root');
            $config->set('dbpass', 'teamomiyalee19');
            break;
        case 'development':
            $config->set('BaseUrl', 'http://smartemergency.altiviaot.com/api');
            $config->set('driver', 'mysql');
            $config->set('dbhost', 'localhost');
            $config->set('dbname', 'altiviao_smartemergency');
            $config->set('dbuser', 'root');
            $config->set('dbpass', 'q6td9.9fmq3');
            break;
        case 'production':
            $config->set('BaseUrl', 'http://smartemergency.altiviaot.com/api');
            $config->set('driver', 'mysql');
            $config->set('dbhost', 'localhost');
            $config->set('dbname', 'altiviao_smartemergency');
            $config->set('dbuser', 'root');
            $config->set('dbpass', 'q6td9.9fmq3');
            break;
    }

    $config->set('MDKey', 'ba79c7513cc983ae735fe9f66f100889');
    $config->set('address', '127.0.0.1');
    $config->set('port', '8586');
?>
