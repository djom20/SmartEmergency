<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProcesoController
 *
 * @author edinson
 */
class ProcesoController extends ControllerBase {
    //put your code here
    function get () {
        $params = Partial::prefix($this->get, ':');
        
        $result = $this->getModel('lista_proceso')->select(
            $params
        );
        
        $response = Partial::arrayNames($result);
        
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }

    function details () {
        $_filled = Partial::_filled($this->post, array('idproceso'));
        if($_filled) {
            $result = $this->getModel('lista_proceso')->select(
                array(':idproceso' => $this->post['idproceso'])
            );

            if(count($result) > 0) {
                $response = Partial::arrayNames($result);
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
            }
            
            HTTP::JSON(403);
        }
        HTTP::JSON(400);
    }
    
    function add () {
        $_filled = Partial::_filled($this->post, array ('nombre', 'idagencia', 'idmotonave'));
        $_empty = Partial::_empty($this->post, array ('idproceso', 'idestado'));
        
        if($_filled && $_empty) {
            $disponible = $this->getModel('motonave_disponible')->select(array (
                ':idmotonave' => $this->post['idmotonave']
            ));
            
            if(count($disponible) > 0) {
                $this->post['idestado'] = '1';

                $params = Partial::prefix($this->post, ':');

                $process = $this->getModel('proceso');
                $process->insert($params);

                if($process->lastID() > 0) {
                    $this->post['idproceso'] = $process->lastID();
                    $this->remainder($this->post['idproceso'],'');
                    HTTP::JSON(Partial::createResponse(HTTP::Value(200), $this->post));
                }
            }
            
            HTTP::JSON(403);
        }
        
        HTTP::JSON(Partial::createResponse(HTTP::Value(400)));
    }

    function remainder($idproceso, $option){
        $result =  Partial::arrayNames($this->getModel('lista_proceso')->select(array(
            ':idproceso' => $idproceso
        )));

        $agencia = $result[0]['idagencia'];

        if(count($result) == 1){
            $headers = "From: " . strip_tags('no-reply@example.com') . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $table = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:2px solid #9b9b9b\">
                        <tbody>
                            <tr>
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b; text-align: center;\">
                                    <img width=\"135\" height=\"131\" src=\"http://pilotos.soluntech.com/css/imgs/logo.png\" alt=\"header\" />
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <span style=\"float:left\">
                                        <strong>:nombre</strong>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Motonave</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Agencia</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Creacion</strong>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :motonave
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :agencia
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                    :inicio
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Eventos</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Estado</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Finalizacion</strong>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :eventos
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :estado
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                    :fin
                                </td>
                            </tr>
                            <tr>
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <center><strong>Comentarios</strong></center>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td colspan=\"3\">:observacion</td>
                            </tr>
                        </tbody>
                    </table>";

            $table = Partial::fetchRows($result, $table);

            $html = "<html>
                        <head>
                            <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
                            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                            <style>
                                * {
                                    font-family: 'Roboto', sans-serif;
                                    outline: none;
                                }
                                td {
                                    width: 900px;
                                }
                            </style>
                        </head>
                        <body>". $table ."</body>
                    </html>";

            $piloto =  Partial::arrayNames($this->getModel('evento')->select(array(
                ':idproceso' => $idproceso
            )));

            $result = Partial::arrayNames(
                // $this->getModel('subscribed_users')->select()
                $this->getModel('subscribed_users')->select("(idrol IN (1,5)) OR (idrol IN (2,4) AND idagencia = " . $agencia . ") OR (idrol = ". $piloto['idpiloto'] ." AND idagencia = " . $agencia . ")")
            );

            $user_list = '';

            foreach ($result as $key => $value) {
                $user_list .= $value["correo"].", ";
            }

            $user_list = (strlen($user_list) > 0) ? substr($user_list, 0, -2) : $user_list;
            if($option == "observacion"){
                mail($user_list, 'El Proceso ' . $idproceso . ' tiene una nueva observacion - Pilotos', $html, $headers);
            }else{
                mail($user_list, 'Creado Proceso ' . $idproceso . ' - Pilotos', $html, $headers);
            }

            $this->push($idproceso, $option);
            HTTP::JSON(200);
        }

        HTTP::JSON(400);
    }

    function push($idproceso, $option){
        $result =  Partial::arrayNames($this->getModel('lista_proceso')->select(array(
            ':idproceso' => $idproceso
        )));

        if(count($result) == 1){
            $result2 = Partial::arrayNames(
                $this->getModel('subscribed_users')->select()
            );

            $result = $result[0];
            $result['eventos'] = (integer) $result['eventos'];

            if($option == "observacion"){
                $finalize = " tiene una observacion";
            }else if($result['estado'] == "Creado" && $result['eventos'] == 0){
                $finalize = " ha sido creado";
            }else if($result['estado'] == "Creado" && $result['eventos'] > 0){
                $finalize = " ha sido actualizado";
            }else if($result['estado'] == "En Proceso"){
                $finalize = " ha sido en proceso";
            }else if($result['estado'] == "Finalizado"){
                $finalize = " ha sido finalizado";
            }

            $messagge = "El proceso " . $result['nombre'] . $finalize;
            foreach ($result2 as $key => $value) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/x-www-form-urlencoded;charset=utf-8"
                ));
                 
                // definimos la URL a la que hacemos la petición
                curl_setopt($ch, CURLOPT_URL,"http://pilotosbarranquilla.com/notifi3r/push/send");
                // definimos el número de campos o parámetros que enviamos mediante POST
                curl_setopt($ch, CURLOPT_POST, 1);
                // definimos cada uno de los parámetros
                $params = "user_id={$value["idusuario"]}&message={$messagge}";
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                 
                // recibimos la respuesta y la guardamos en una variable
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);

                // cerramos la sesión cURL
                // var_dump($remote_server_output);
                curl_close ($ch);
            }

            HTTP::JSON(200);
        }

        HTTP::JSON(400);
    }

    function push_(){
        $idproceso = $this->post['idproceso'];
        $result =  Partial::arrayNames($this->getModel('lista_proceso')->select(array(
            ':idproceso' => $idproceso
        )));

        if(count($result) == 1){
            $result2 = Partial::arrayNames(
                $this->getModel('subscribed_users')->select()
            );

            $result = $result[0];
            $result['eventos'] = (integer) $result['eventos'];

            if($result['estado'] == "Creado" && $result['eventos'] == 0){
                $finalize = " ha sido creado";
            }else if($result['estado'] == "Creado" && $result['eventos'] > 0){
                $finalize = " ha sido actualizado";
            }else if($result['estado'] == "En Proceso"){
                $finalize = " ha sido en proceso";
            }else if($result['estado'] == "Finalizado"){
                $finalize = " ha sido finalizado";
            }

            $messagge = "El proceso " . $result['nombre'] . $finalize;
            foreach ($result2 as $key => $value) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/x-www-form-urlencoded;charset=utf-8"
                ));
                 
                // definimos la URL a la que hacemos la petición
                curl_setopt($ch, CURLOPT_URL,"http://pilotosbarranquilla.com/notifi3r/push/send");
                // definimos el número de campos o parámetros que enviamos mediante POST
                curl_setopt($ch, CURLOPT_POST, 1);
                // definimos cada uno de los parámetros
                $params = "user_id={$value["idusuario"]}&message={$messagge}";
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                 
                // recibimos la respuesta y la guardamos en una variable
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);

                // cerramos la sesión cURL
                // var_dump($remote_server_output);
                curl_close ($ch);
            }

            HTTP::JSON(200);
        }

        HTTP::JSON(400);
    }

    function observacion () {
        $_filled = Partial::_filled($this->post, array ('idproceso'));
        
        if($_filled) {
            $this->getModel('proceso')->update($this->post['idproceso'], array (
                ':observacion' => $this->post['observacion']
            ));

            $this->remainder($this->post['idproceso'], 'observacion');

            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    function listas () {
        $params = array ();
        
        $params['agencia'] = Partial::arrayNames(
            $this->getModel('agencia')->select()
        );
        
        $params['motonave'] = Partial::arrayNames(
            $this->getModel('motonave_disponible')->select()
        );
        
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $params));
    }
    
    function finalize () {
        $_filled = Partial::_filled($this->delete, array ('idproceso'));
        $_get = Partial::_filled($this->get, array ('idproceso'));
        
        if($_filled) {
            $activos = $this->getModel('evento')->count(array (
                ':idproceso' => $this->delete['idproceso'],
                ':id_estado' => '1'
            ));
            
            if($activos > 0) {
                HTTP::JSON(Partial::createResponse(HTTP::Value(403), 'Debe cerrar todas las maniobras primero'));
            }
            
            $this->getModel('proceso')->update($this->delete['idproceso'], array (
                ':idestado' => '3',
                ':fin' => date("Y-m-d H:i:s")
            ));
            $this->remainder($this->delete['idproceso'],'');
            HTTP::JSON(200);
        } elseif($_get) {
            $activos = $this->getModel('evento')->count(array (
                ':idproceso' => $this->get['idproceso'],
                ':id_estado' => '1'
            ));
            
            if($activos > 0) {
                HTTP::JSON(Partial::createResponse(HTTP::Value(403), 'Debe cerrar todas las maniobras primero'));
            }
            
            $this->getModel('proceso')->update($this->get['idproceso'], array (
                ':idestado' => '3',
                ':fin' => date("Y-m-d H:i:s")
            ));
            $this->remainder($this->get['idproceso'],'');
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
}

