<?php 

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;


        //Métodos mágicos
        //Get
        public function __get($atributo){
            return $this->$atributo;
        }
        //Set
        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }
        //Método verifica se algum dos campos não foi preenchido
        public function MensagemValida(){
           if(empty($this->para)||empty($this->assunto)||empty($this->mensagem)){
                return false;
           }
           return true;
        }
    }

    $mensagem = new mensagem();

    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    if($mensagem->MensagemValida()){
        echo 'Mensagem é válida';
    } else {
        echo 'Mensagem não é válida';
    }

?>