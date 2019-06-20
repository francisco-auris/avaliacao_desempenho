<?php
ini_set( 'display_errors', true );
error_reporting( E_ALL );

require_once "Controller/CConexao.php";

class Printer extends CConexao {

    private $conn;

    function __construct(){
        $this->conn = $this->conectar();
    }   

    public function getTables(){
        //pega arrays objetos
        $pacotes   = $this->getPacotes();
        $perguntas = $this->getPerguntas();
        $competencias = $this->getCompetencias();
        //vef
        if( $pacotes == null OR $perguntas == null OR $competencias == null ){ echo "ERROR"; exit; }
        //continue
        for( $i = 0; $i < count($pacotes); $i++ )
        {
            //for dos pacotes
            echo '<table width="100%" style="border-collapse:collapse;page-break-after: always;" border=1 >';
            echo '<thead>';
                $tipo = ($pacotes[$i]->msearch == '0' AND $pacotes[$i]->tipo == 'O') ? "OPERACIONAL" : ( ($pacotes[$i]->msearch == '0' AND $pacotes[$i]->tipo == 'T') ? 'TATICO' : 'ESTRATEGICO' );
                echo '<td colspan="2" height="120" align="center" valign="middle">'.utf8_encode((($pacotes[$i]->msearch == '0') ? $tipo : $pacotes[$i]->msearch)).'</td>';
            echo '</thead>';
            echo '<tbody>';

            /*if( $pacotes[$i]->msearch == '0' )
            {*/
                echo '<tr>';
                echo '<td colspan="2"><b>'.( ($pacotes[$i]->msearch == '0') ? "AVALIAÇÃO COMPORTAMENTAL" : "AVALIAÇÃO TÉCNICA" ).'</b></td>';
                echo '</tr>';

                $_comp = explode( "/", $pacotes[$i]->pcompetencia );
                for( $x = 0; $x < count($competencias); $x++ )
                {
                    for( $t = 0; $t < count($_comp); $t++ ){
                        if( $competencias[$x]->idcompetencia == $_comp[$t] )
                        {
                            $_perg = explode( "/", $competencias[$x]->cpergunta );

                            echo '<tr><td colspan="2" bgcolor="#EEE">'.$competencias[$x]->titulo.'</td></tr>';
                            //inicio do for de perguntas
                            for( $p = 0; $p < count($perguntas); $p++ )
                            {
                                for( $a = 0; $a < count($_perg); $a++ ){
                                    if( $perguntas[$p]->idpergunta == $_perg[$a] ){
                                        echo '<tr>';
                                        echo '<td>'.$perguntas[$p]->idpergunta.'</td>';
                                        echo '<td>'.$perguntas[$p]->contexto.'</td>';
                                        echo '</tr>';
                                    }
                                }
                            }
                            //fim do for de perguntas
                        }
                    }
                    
                }
            /*}
            else 
            {

            }*/

            echo '</tbody>';
            echo '</table><br>';
            echo '<script>window.print();</script>';
            //end for dos pacotes
        }

    }

    private function getPacotes(){
        $sql = "SELECT * FROM pacote";
        $query = $this->conn->query( $sql );
        if( $query and $query->rowCount() > 0 ){
            $obj = $query->fetchAll(PDO::FETCH_OBJ);
            return $obj;
        }
        else {
            return null;
        }
    }   
    
    private function getCompetencias(){
        $sql = "SELECT * FROM competencia";
        $query = $this->conn->query( $sql );
        if( $query and $query->rowCount() > 0 ){
            $obj = $query->fetchAll(PDO::FETCH_OBJ);
            return $obj;
        }
        else {
            return null;
        }
    }

    private function getPerguntas(){
        $sql = "SELECT * FROM .pergunta";
        $query = $this->conn->query( $sql );
        if( $query and $query->rowCount() > 0 ){
            $obj = $query->fetchAll(PDO::FETCH_OBJ);
            return $obj;
        }
        else {
            return null;
        }
    }


}

//init exec
$var = new Printer();
$var->getTables();