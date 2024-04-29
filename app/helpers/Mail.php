<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require APPROOT . '/mail/src/Exception.php';
require APPROOT . '/mail/src/PHPMailer.php';
require APPROOT . '/mail/src/SMTP.php';
class Mail
{
    public $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to 0 for production
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable debug output
        // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable debug output
        // $this->mail->Debugoutput = function ($str, $level) {
        //     echo "Debug level $level; message: $str<br>";
        // };
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'healthwave.services@gmail.com'; // SMTP username
        $this->mail->Password = 'yhhi mivm ncqb qztv'; // SMTP password
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587; // TCP port to connect to
    }
    public function send($to, $subject, $body)
    {
        try {
            $this->mail->setFrom('services.healthwave@gmail.com', 'HealthWave');
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }
}
