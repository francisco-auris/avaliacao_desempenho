$(document).ready(function(){
	//veirifca formulario de delete pacote
});

function calMediaComp( idPErgunta,idComp ){
	var total = $("span[class=total_"+idComp+"]").text();
	var media = pegaValor(idComp);
	if( total=="" ){
		$("span[class=total_"+idComp+"]").text( media );
	}else {
		$("span[class=total_"+idComp+"]").text( media );
	}
}

function calMediaCompC( idPErgunta,idComp ){
	//alert(idPErgunta);
	var total = $("span[class=total_"+idComp+"]").text();
	var media = pegaValorC(idComp);
	console.log("media => "+media);
	if( total=="" ){
		$("span[class=total_"+idComp+"]").text( media );
	}else {
		$("span[class=total_"+idComp+"]").text( media );
	}
}

function pegaValor( idComp ){
	var tds = $("input[data-comp="+idComp+"]").length;
	var soma=0;
	var valores = new Array();
	var flag=0;
	tds = tds / 4;

	for( var x=1; x <= tds; x++ ){
		if( $("input[data-comp="+idComp+"][data-seq="+x+"]:checked") ){
			valores[x] = parseInt($("input[data-comp="+idComp+"][data-seq="+x+"]:checked").val());
		}else {
			flag = 1;
		}
	}

	if( flag == 0 ){
		for( var j=1; j <= tds; j++ ){
			//alert(valores[j]);
			soma = soma + valores[j];
		}
		var media = soma / tds;
		media = media.toFixed(1);
	}
	else {
		media = 0;
	}
	return media;
}
function pegaValorC( idComp ){
	var tds = $("input[data-comp="+idComp+"]").length;
	//console.log("Perguntas: "+tds);
	var soma=0;
	var valores = new Array();
	var flag=0;
	tds = tds / 3;

	for( var x=1; x <= tds; x++ ){
		if( $("input[data-comp="+idComp+"][data-seq="+x+"]:checked") ){
			valores[x] = parseInt($("input[data-comp="+idComp+"][data-seq="+x+"]:checked").val());
		}else {
			flag = 1;
		}
	}

	if( flag == 0 ){
		for( var j=1; j <= tds; j++ ){
			//alert(valores[j]);
			soma = soma + valores[j];
		}
		var media = soma / tds;
		media = media.toFixed(1);
	}
	else {
		media = 0;
	}
	//alert(media);
	return media;
}

function fontMaior(){
	var tam = $("input[name=font]").val();
	if( tam <= 50){
		if( tam=="" ){
		tam = 10;
		tam = parseInt(tam);
		}else {
			tam = parseInt(tam);
		}
		var novo = tam + 6;
		 novo = parseInt(novo);
		$("input[name=font]").val(novo);
		novo = novo+"px";
		$(".table").css('font-size', novo);
		$(".list-group-item").css('font-size', novo);
	}
	
}
function fontMenor(){
	var tam = $("input[name=font]").val();
	if( tam > 0 ){
		if( tam=="" ){
		tam = 10;
		tam = parseInt(tam);
		}else {
			tam = parseInt(tam);
		}
		var novo = tam - 6;
		 novo = parseInt(novo);
		$("input[name=font]").val(novo);
		novo = novo+"px";
		$(".table").css('font-size', novo);
		$(".list-group-item").css('font-size', novo);
	}
	
}

function messagePreUrl( texto, url ){
	var html = '<div id="modalDel" class="modal fade" role="dialog">';
    html += '<div class="modal-dialog">';

    html += '<!-- Modal content-->';
    html += '<div class="modal-content">';
    html += '  <div class="modal-header">';
    html += '    <button type="button" class="close" data-dismiss="modal">&times;</button>';
    html += '    <h4 class="modal-title">Deseja mesmo deletar esse(a) '+texto+' ?</h4>';
    html += '  </div>';
    html += '  <div class="modal-body">';
    html += '    <center><a href="'+url+'" class="btn btn-danger">SIM</a> <a class="btn btn-default" data-dismiss="modal">NÃO</a></center>';
    html += '  </div>';
    html += ' </div>';

  	html += '</div>';
	html += '</div>';

	$(html).modal('show');
}

