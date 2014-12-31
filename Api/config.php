<?php
    $config = Config::singleton();

    //Folders' Direction
    $config->set('controllersFolder', 'Controllers/');
    $config->set('modelsFolder', 'Models/');
    $config->set('xmlFolder', 'Models/xml/');
    $config->set('wsFolder', 'Models/services/');
    $config->set('viewsFolder', 'Views/');
    $config->set('templatesFolder', 'Templates/');
    
    $config->set('Template', 'default.php');

    //Vars URL
    $config->set('BaseUrl', 'http://localhost/pilotos/api');
    // $config->set('BaseUrl', 'http://54.173.110.192/pilotos');

    //Data Base Configuration
    $config->set('driver', 'mysql');
    $config->set('dbhost', 'localhost');
    $config->set('dbname', 'pilotos');
    $config->set('dbuser', 'root');
    $config->set('dbpass', 'q6td9.9fmq3');