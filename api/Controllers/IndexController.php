<?php
	class IndexController extends ControllerBase {
	    public function index() {
	        $this->view->show('index/index.php');
	    }
	}
?>