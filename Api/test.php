<?php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded;charset=utf-8"
    ));
     
    // definimos la URL a la que hacemos la petición
    curl_setopt($ch, CURLOPT_URL,"http://pilotosbarranquilla.com/notifi3r/push/send");
    // definimos el número de campos o parámetros que enviamos mediante POST
    curl_setopt($ch, CURLOPT_POST, 1);
    // definimos cada uno de los parámetros
    $params = "user_id=5354546584&message=Hola Mundo";
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
     
    // recibimos la respuesta y la guardamos en una variable
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec ($ch);

    // cerramos la sesión cURL
    var_dump($remote_server_output);
    curl_close ($ch);
?>