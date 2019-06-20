<?php
class MFuncionario extends CConexao {

	private $id;

	protected function listFunc(){

		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM funcionario ORDER BY nome ASC");
		if( $query ){
			include_once "View/list/list_funcionarios.php";
		}
		else {
			CMessage::danger('Impossivel buscar funcionarios.');
		}

	}

	protected function search(){

		$cconexao = $this->conectar();
		$this->id = base64_decode($_GET['id']);
		$query = $cconexao->prepare("SELECT * FROM funcionario WHERE matricula=:matricula");
		 $query->bindParam(":matricula", $this->id, PDO::PARAM_INT);
		if( $query->execute() ){
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			include_once "View/modal/funcionario_update.php";
		}
		else {
			CMessage::danger('Impossivel buscar funcionarios.');
		}

	}

	protected function execInsert(){

		$cconexao = $this->conectar();
		if( $_POST['nome']=="" OR $_POST['matricula']=="" OR $_POST['setor']=="" OR $_POST['funcao']=="" OR $_POST['admissao']=="" ){
			CMessage::danger("Campos vazios");
		}else {
			$query = $cconexao->prepare("INSERT INTO funcionario (nome,matricula,setor,funcao,nivelavaliador,horario,admissao,empresa,nascimento,imediato,superior) VALUES (:nome, :matricula, :setor, :funcao, :nivel, :horario, :admissao, :empresa, :nascimento, :imediato, :superior)");
			$query->bindParam(":nome", $_POST['nome'], PDO::PARAM_STR);
			$query->bindParam(":matricula", $_POST['matricula'], PDO::PARAM_INT);
			$query->bindParam(":setor", $_POST['setor'], PDO::PARAM_STR);
			$query->bindParam(":funcao", $_POST['funcao'], PDO::PARAM_STR);
			$query->bindParam(":nivel", $_POST['nivel'], PDO::PARAM_STR);
			$query->bindParam(":horario", $_POST['horario'], PDO::PARAM_STR);
			$query->bindParam(":admissao", $_POST['admissao'], PDO::PARAM_STR);
			$query->bindParam(":empresa", $_POST['empresa'], PDO::PARAM_STR);
			$query->bindParam(":nascimento", $_POST['nascimento'], PDO::PARAM_STR);
			$query->bindParam(":imediato", $_POST['imediato'], PDO::PARAM_INT);
			$query->bindParam(":superior", $_POST['superior'], PDO::PARAM_STR);

			if( $query->execute() ){
				CMessage::fixed('Funcionario cadastrado.','success');
			}	
			else {
				CMessage::danger('Error ao tentar cadastrar novo funcionarios.');
			}
		}

	}

	protected function execUpdate(){

		$cconexao = $this->conectar();

		$query = $cconexao->prepare("UPDATE funcionario set nome=:nome,matricula=:matricula,setor=:setor,funcao=:funcao,nivelavaliador=:nivel,horario=:horario,admissao=:admissao,empresa=:admissao,nascimento=:nascimento,imediato=:imediato,superior=:superior WHERE matricula=:matricula");
		$query->bindParam(":nome", $_POST['nome'], PDO::PARAM_STR);
		$query->bindParam(":matricula", $_POST['matricula'], PDO::PARAM_INT);
		$query->bindParam(":setor", $_POST['setor'], PDO::PARAM_STR);
		$query->bindParam(":funcao", $_POST['funcao'], PDO::PARAM_STR);
		$query->bindParam(":nivel", $_POST['nivel'], PDO::PARAM_STR);
		$query->bindParam(":horario", $_POST['horario'], PDO::PARAM_STR);
		$query->bindParam(":admissao", $_POST['admissao'], PDO::PARAM_STR);
		$query->bindParam(":empresa", $_POST['empresa'], PDO::PARAM_STR);
		$query->bindParam(":nascimento", $_POST['nascimento'], PDO::PARAM_STR);
		$query->bindParam(":imediato", $_POST['imediato'], PDO::PARAM_INT);
		$query->bindParam(":superior", $_POST['superior'], PDO::PARAM_STR);

		if( $query->execute() ){
			CMessage::sucesso('Funcionario atualizado.');
		}	
		else {
			CMessage::danger('Error ao tentar atualizar dados de funcionarios.');
		}

	}

	protected function execDelete(){

		$cconexao = $this->conectar();
		$matricula = base64_decode($_GET['id']);

		$query = $cconexao->query("DELETE FROM funcionario WHERE matricula='$matricula'");
		if( $query ){
			//CMessage::fixed('Funcionario deletado.','success');
			CCentral::redireciona('?window=funcionario');
		}
		else {
			CMessage::fixed('Funcionario não deletado.','danger');
		}

	}
}
?>