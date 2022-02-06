<?php
namespace BlogApp\Mailer;
  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MyMailer 
{ 
    protected $mail; 
    function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function formatMail($messageEmail, $message)
    {
        return '<h4>Message envoyer depuis mon site Watersport-gear</h4>
            <h6><b>Email : </b>' . $messageEmail . '</h6><br>
            <p><b>Message : </b>' . htmlspecialchars($message) . '</p>';
    }

    public function SendTheMail($message)
    {
        try 
        {
            $this->mail->SMTPDebug = 2;      // ou 3, ou 4                                 
            $this->mail->isSMTP();                                            
            $this->mail->Host       = 'smtp.gmail.com;';                    
            $this->mail->SMTPAuth   = true;                             
            $this->mail->Username   = 'ikanhiumalam@gmail.com';                 
            $this->mail->Password   = '2108gmaiL';                        
            $this->mail->SMTPSecure = 'tls';    // ou ssl                          
            $this->mail->Port       = 587;  
          
            $this->mail->setFrom('ikanhiumalam@gmail.com', 'Moi');           
            $this->mail->addAddress('ikanhiu@outlook.fr');
 
            $this->mail->isHTML(true);                                  
            $this->mail->Subject = 'essai';
            $this->mail->Body    = $message;
            $this->mail->AltBody = 'Body in plain text for non-HTML mail clients';

            $this->mail->send();

            $message =  "Le mail a été envoyé ! ";
        } 
        catch (Exception $e) 
        {
            $message =  "Le Mail n'est pas parti : Erreur : {$this->mail->ErrorInfo}";
        }
        return $message ;
    }
}
  