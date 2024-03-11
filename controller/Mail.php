<?php

//Адрес получателя захардкожен, чтобы тестить изменения паролей БД

namespace controller;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{

    // функция отправки почты через библиотеку PHPMailer
    public function sendByMail($email, $generateResetToken): void
    {
        $config = require "config/bd.php";

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $config['mail']['host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = $config['mail']['sender'];                     //SMTP username - от кого будет отправляться
            $mail->Password = $config['mail']['password'];                               //SMTP password - пароль от кого будет отправлять
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port = 587;
            $mail->CharSet = "UTF-8";

            //Recipients
            $mail->setFrom($config['mail']['sender'], $config['mail']['sender-name']);
            $mail->addAddress('shobuhin@mail.ru', 'Sergey Sergey');     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Сброс пароля у ' . $email;
            $mail->Body = 'Ваш новый пароль:<br>' . $generateResetToken . '<br>Не забудьте поменять его в личном кабинете';
            $mail->AltBody = 'Произошла смена пароля у ' . $email;

            $mail->send();
            echo 'Сообщение отправлено';

            //как организовать передачу сообщение на login
//            $this->setLayout('login')->render([
//                    'message' => 'Сообщение с новым  паролем отправлено на почту: ' . $email
//                ]);
            header('Location: /user/login');

        } catch (Exception $e) {
            echo "Сообщение не может быть отправлено. Ошибка почтовой программы: {$mail->ErrorInfo}";
        }
    }
}