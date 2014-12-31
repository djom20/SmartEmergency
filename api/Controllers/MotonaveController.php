<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NaveController
 *
 * @author edinson
 */
class MotonaveController extends ControllerBase {
    //put your code here
    function get () {
        $params = Partial::prefix($this->get, ':');
        
        $result = $this->getModel('motonave')->select(
            $params
        );
        
        $response = Partial::arrayNames($result);
        
        HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
    }
    
    function add () {
        $_filled = Partial::_filled($this->post, array ('nombre', 'bandera', 'trb'));
        $_empty = Partial::_empty($this->post, array ('idmotonave'));
        
        if($_filled && $_empty) {
            $params = Partial::prefix($this->post, ':');
            
            $motonave = $this->getModel('motonave');
            $motonave->insert($params);
            
            if($motonave->lastID() > 0) {
                $this->post['idmotonave'] = $motonave->lastID();
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), $this->post));
            }
            
            HTTP::JSON(403);
        }
        
        HTTP::JSON(400);
    }

    function edit () {
        $_filled = Partial::_filled($this->put, array ('idmotonave'));
        
        if($_filled) {
            $params = Partial::prefix($this->put, ':');
            
            $this->getModel('motonave')->update($this->put['idmotonave'], $params);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
    
    function delete () {
        $_filled = Partial::_filled($this->delete, array ('idmotonave'));
        $_get = Partial::_filled($this->get, array ('idmotonave'));
        
        if($_filled) {
            $this->getModel('motonave')->delete($this->delete['idmotonave']);
            
            HTTP::JSON(200);
        } elseif($_get) {
            $this->getModel('motonave')->delete($this->get['idmotonave']);
            
            HTTP::JSON(200);
        }
        
        HTTP::JSON(400);
    }
}
