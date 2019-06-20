<?php
class ReportGestor extends MReportGestor {
	
	function __construct(){
		if( empty( $_GET['id'] ) ){
			$this->listColaboradores();
		}
		else {
			$this->searchData();
			$this->geraRelatorio();
		}
	}
}
?>