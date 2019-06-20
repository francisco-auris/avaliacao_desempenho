<?php
class ReportTatico extends MReportTatico {
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