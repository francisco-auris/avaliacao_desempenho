<?php
class ReportPerguntas extends MReportPerguntas {
	
	function __construct(){
		if( empty( $_GET['id'] ) ){
			$this->listPerguntas();
		}
	}
}
?>