<?php

//Import dos arquivos da biblioteca PHPMailer
require "./bibliotecas/PHPMailer/DSNConfigurator.php";
require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuthTokenProvider.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";

//Import dos namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Excpetion;




class Mensagem
{
    private $para = null;
    private $assunto = null;
    private $mensagem = null;


    //Métodos mágicos
    //Get
    public function __get($atributo)
    {
        return $this->$atributo;
    }
    //Set
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }
    //Método verifica se algum dos campos não foi preenchido
    public function MensagemValida()
    {
        if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }
        return true;
    }
}

$mensagem = new mensagem();

$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if (!$mensagem->MensagemValida()) {
    echo 'Mensagem não é válida';
    die();
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'josiasdev97@gmail.com';                     //SMTP username
    $mail->Password   = 'minhasenha';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('josiasdev97@gmail.com', 'Josias Remetente');
    $mail->addAddress('josiasdev97@gmail.com', 'Josias Destinatário');     //Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Assunto';
    $mail->Body    = 'Conteúdo do <b>E-mail</b>';
    $mail->AltBody = 'Conteúdo do E-mail';

    $mail->send();
    echo 'E-mail enviado com sucesso.';
} catch (Exception $e) {
    echo 'Não foi possível enviar este e-mail. Por favor, tente novamente mais tarde!';
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
