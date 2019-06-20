$(document).ready(function(){

});

function total( matricula ){

	if( matricula=="" ){
		alert('Matricula vazia.');
	}
	else {
		iframeTotal(matricula);	
	}

}

function iframeTotal( matricula ){
	var html = '<div id="modalIframe" class="modal fade" role="dialog">';
    html += '<div class="modal-dialog modal-lg">';

    html += '<!-- Modal content-->';
    html += '<div class="modal-content" style="height:550px;">';
    html += '  <div class="modal-header">';
    html += '    <button type="button" class="close" data-dismiss="modal">&times;</button>';
    //html += '    <h4 class="modal-title">Deseja mesmo deletar esse(a) '+texto+' ?</h4>';
    html += '  </div>';
    html += '  <div class="modal-body">';
    html += '    <center><iframe src="Model/ResumoAtividade.ajax.php?matricula='+matricula+'" class="iframetotal" style="border:0;width:100%;height:400px;"></iframe></center>';
    html += '  </div>';
    html += ' </div>';

  	html += '</div>';
	html += '</div>';

	$(html).modal('show');
}