<?php
/**
 * User: nester_a
 * Date: 25.02.14
 */

spl_autoload_unregister(array('YiiBase','autoload'));
Yii::import('application.extensions.swiftmailer.swift_required', true);
spl_autoload_register(array('YiiBase','autoload'));

class SwiftMailer extends CComponent
{
    public $fromEmail;
    public $transportType;
    public $transportOptions = array(
        'host'=>'smtp.host.com',
        'username'=>'username',
        'password'=>'password',
        'port'=>'25',
    );

    public function init()
    {

    }


    public function send($from, $to, $subject, $message)
    {
        $message = Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($from)
                    ->setTo($to)
                    ->setBody($message, 'text/html');

        $transport = Swift_SmtpTransport::newInstance($this->transportOptions['host'], $this->transportOptions['port'])
                            ->setUsername($this->transportOptions['username'])
                            ->setPassword($this->transportOptions['password']);

        $mailer = Swift_Mailer::newInstance($transport);
        try{
            return $mailer->send($message);
        }catch(Exception $e){
            throw new CHttpException($e->getCode(), $e->getMessage());
        }
    }


    public function sendFromAdmin($to, $subject, $message)
    {
        return $this->send($this->getFromEmail(), $to, $subject, $message);
    }

    public function setTransportOptions($transportOptions)
    {
        $this->transportOptions = $transportOptions;
    }

    public function getTransportOptions()
    {
        return $this->transportOptions;
    }

    public function setTransportType($transportType)
    {
        $this->transportType = $transportType;
    }

    public function getTransportType()
    {
        return $this->transportType;
    }

    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function getFromEmail()
    {
        return $this->fromEmail;
    }




}