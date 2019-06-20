<?php
class MReportPerguntas extends CConexao {
    
    protected function listPerguntas(){

        $conn = $this->conectar();

        $query = $conn->query("SELECT * FROM competencia");

        echo '<div class="container"><br><br>';

        $comp = $query->fetchAll(PDO::FETCH_OBJ);

        for( $j=0; $j < count($comp); $j++ ){
            
            echo '<h3><small><strong>'.$comp[$j]->titulo.'</strong></small></h3>';
            echo '<hr>';
            $explode = explode("/",$comp[$j]->cpergunta);

            for( $i=0; $i < count($explode); $i++ ){

                $query = $conn->query("SELECT * FROM pergunta WHERE idpergunta='".$explode[$i]."'");
                $dados = $query->fetch(PDO::FETCH_ASSOC);
                echo $dados['contexto'].'<br>';

            }

        }

        echo '<div>';

    }

}