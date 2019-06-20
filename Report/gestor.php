<div class="container">
<br><br><br>
	<table class="table" border="1">
		<thead>
			<tr>
				<td align="center" colspan="4">
					<img src="images/cobap_rh.png" width="120" style="float: left;margin-right: -100px;">
					 <div class="page-header" style="border: 0 !important;margin-bottom:-20px !important;">
				      <h3>RELATÓRIO RESUMO NÍVEL ESTRATÉGICO</h3>
				    </div>
				</td>
			</tr>
		</thead>
		<tr>
			<td colspan="2"><b>NOME:</b> <?php echo $this->dados['nome'];?></td>
			<td><b>MATRICULA:</b> <?php echo $this->dados['matricula'];?></td>
		</tr>
		<tr>
			<td><b>FUNÇÃO:</b> <?php echo $this->dados['funcao'];?></td>
			<td><b>SETOR:</b> <?php echo $this->dados['setor'];?></td>
			<td><b>AVALIADOR:</b> <?php echo $this->dados['gestor'];?></td>
		</tr>
		<tr><td colspan="3">&ensp;</td></tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>NOTAS</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA ATENDE </b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>A PARTIR 8,5</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA A SER DESENVOLVIDA</b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>ENTRE 8,4 - 0,0</b></td>
		</tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMPETÊNCIAS A SEREM AVALIADAS</b></td>
		</tr>
		<?php
			$this->viewNotas();
		?>
		<tr>
			<td colspan="3"><b>TÉCNICA</b></td>
		</tr>

		<?php
		$valores = explode("/", $this->avl);
		//echo count($valores);
		$total_tecnica = 0;
		$cconexao = $this->conectar();
		for( $j=0; $j < count($valores); $j++ ){
			$script = "SELECT * FROM resposta AS resp INNER JOIN pergunta AS pg ON resp.idpergunta = pg.idpergunta WHERE resp.idpergunta='".$valores[$j]."' AND avaliador='".$this->gestor."' AND avaliado='".$this->id."'";
			$temp = $cconexao->query( $script );
			if( $temp ){

				$datas = $temp->fetch(PDO::FETCH_ASSOC);
				echo '<tr>';
					echo '<td colspan="2">'.$datas['contexto'].'</td>';
					echo '<td >'.$datas['nota'].'</td>';
				echo '</tr>';
				$total_tecnica = $total_tecnica + $datas['nota'];

			}else {
				echo '<tr>';
					echo '<td colspan="3">NOT</td>';
				echo '</tr>';
			}
			
		}
		?>
		<tr>
			<td colspan="3" align="right"><b>NOTA GERAL: </b><?php echo number_format($total_tecnica/count($valores), 2, '.', '');?></td>
		</tr>

		<tr><td colspan="3" class="grayb" align="center"><b>FEEDBACK</b></tr>
		<tr><td colspan="3" class="gray" align="center"><b>HOUVE CONCESSO DE TODOS OS PONTOS AVALIADOS? SIM (&ensp;&ensp;)  NÃO (&ensp;&ensp;)</b></tr>
		<tr><td colspan="3" class="gray" align="center"><b>SE NÃO, QUAL NÃO HOUVE CONSENSO E PORQUÊ?</b></td></tr>
		<tr><td colspan="3">&ensp;</td></tr><tr><td colspan="3">&ensp;</td></tr><tr><td colspan="3">&ensp;</td></tr>
		<tr><td colspan="3">&ensp;</td></tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>ESSE COLABORADOR DEMONSTRA UM PERFIL DE LIDERANÇA? SIM (&ensp;&ensp;)  NÃO (&ensp;&ensp;) SE SIM, JUSTIFIQUE:</b></td>
		</tr>
		<tr><td colspan="3">&ensp;</td></tr><tr><td colspan="3">&ensp;</td></tr><tr><td colspan="3">&ensp;</td></tr>
		<tr>
			<td align="center">ASSINATURA GESTOR</td><td></td>
			<td align="center">ASSINATURA COLABORADOR</td>
		</tr>
		<tr><td colspan="3" class="gray" align="center"><b>PLANO DE DESENVOLVIMENTO INDIVIDUAL</b></td></tr>
		<tr>
			<td>COMPETÊNCIAS A SEREM DESENVOLVIDAS</td>
			<td>TREINAMENTOS INDICADOS</td>
			<td align="center">DATA PARA REALIZAÇÃO</td>
		</tr>
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	

		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr><td></td><td></td><td align="center">____/____/____</td></tr>	
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMENTÁRIOS DO AVALIADOR</b></td>
		</tr>
		<tr><td colspan="3"><p><b>Comportamental: </b><?php echo ucfirst($this->dados['comentario']);?></p></td></tr>
	</table>
	<br>
	<br>
	<br>
	<table class="table" id="meia" border="1">
		<thead>
			<tr>
				<td align="center" colspan="4">
					<img src="images/cobap_rh.png" width="120" style="float: left;margin-right: -100px;">
					 <div class="page-header" style="border: 0 !important;margin-bottom:-20px !important;margin-top: -3px;">
				      <h3>AUTO AVALIAÇÃO</h3>
				    </div>
				</td>
			</tr>
		</thead>
		<tr>
			<td colspan="3"><b>NOME:</b> <?php echo $this->dados['nome'];?></td>
		</tr>
		<tr>
			<td><b>FUNÇÃO:</b> <?php echo $this->dados['funcao'];?></td>
			<td><b>SETOR:</b> <?php echo $this->dados['setor'];?></td>
			<td><b>MATRICULA:</b> <?php echo $this->dados['matricula'];?></td>
		</tr>
		<tr><td colspan="3">&ensp;</td></tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>NOTAS</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA ATENDE </b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>A PARTIR 8,5</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA A SER DESENVOLVIDA</b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>ENTRE 8,4 - 0,0</b></td>
		</tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMPETÊNCIAS A SEREM AVALIADAS</b></td>
		</tr>
		<?php
		$total = 0;
		for( $j=0; $j < count($this->_auto); $j++ ){
			echo '<tr>';
				echo '<td><b>'.$this->_auto[$j]['titulo'].'</b></td>';
				echo '<td colspan="2">'.number_format($this->_auto[$j]['media'], 2, '.', '').'</td>';
			echo '</tr>';
			$total = $total + $this->_auto[$j]['media'];
		}
		?>
		<tr>
			<td colspan="3" align="right"><b>NOTA GERAL: </b><?php echo number_format($total/count($this->_auto), 2, '.', '');?></td>
		</tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMENTÁRIOS DA AUTO AVALIAÇÃO</b></td>
		</tr>
		<tr><td colspan="3"><p><?php echo ucfirst($this->dados['comentario_auto']);?></p></td></tr>
		<tr><td colspan="3">&ensp;</td></tr>
		<tr>
		<td align="center">ASSINATURA GESTOR</td><td></td>
		<td align="center">ASSINATURA COLABORADOR</td>
		</tr>
	</table>
	<br>
	<br>
	<br>
	<table class="table" id="meia" border="1">
		<thead>
			<tr>
				<td align="center" colspan="4">
					<img src="images/cobap_rh.png" width="120" style="float: left;margin-right: -100px;">
					 <div class="page-header" style="border: 0 !important;margin-bottom:-20px !important;margin-top: -3px;">
				      <h3>RELATÓRIO RESUMO AVALIAÇÃO DA EQUIPE</h3>
				    </div>
				</td>
			</tr>
		</thead>
		<tr>
			<td colspan="3"><b>NOME:</b> <?php echo $this->dados['nome'];?></td>
		</tr>
		<tr>
			<td><b>FUNÇÃO:</b> <?php echo $this->dados['funcao'];?></td>
			<td><b>SETOR:</b> <?php echo $this->dados['setor'];?></td>
			<td><b>MATRICULA:</b> <?php echo $this->dados['matricula'];?></td>
		</tr>
		<tr><td colspan="3">&ensp;</td></tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>NOTAS</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA ATENDE </b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>A PARTIR 8,5</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA A SER DESENVOLVIDA</b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>ENTRE 8,4 - 0,0</b></td>
		</tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMPETÊNCIAS A SEREM AVALIADAS</b></td>
		</tr>
		</tr>
		<?php
		$total = 0;
		for( $j=0; $j < count($this->_equipe); $j++ ){
			echo '<tr>';
				echo '<td><b>'.$this->_equipe[$j]['titulo'].'</b></td>';
				echo '<td colspan="2">'.number_format($this->_equipe[$j]['media'], 2, '.', '').'</td>';
			echo '</tr>';
			$total = $total + $this->_equipe[$j]['media'];
		}
		?>
		<tr>
			<td colspan="3" align="right"><b>QUANTIDADE DE AVALIADORES:</b> <?php echo $this->dados['qtd_equipe'];?>&ensp;&ensp;&ensp;<b>NOTA GERAL: </b><?php echo number_format($total/count($this->_equipe), 2, '.', '');?></td>
		</tr>
		<tr>
			<td colspan="3" align="center" class="gray"><b>COMENTÁRIOS DA EQUIPE</b></td>
		</tr>
		<tr>
			<td colspan="3"><p><?php echo $this->_comentarios;?></p></td>
		</tr>
	</table>
</div>