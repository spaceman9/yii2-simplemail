<?php


namespace spaceman9\simplemail;

use yii\mail\BaseMailer;
use yii\mail\MessageInterface;

class Mailer extends BaseMailer
{

    public $messageClass = 'spaceman9\simplemail\Message';
    /**
     * Sends the specified message.
     * This method should be implemented by child classes with the actual email sending logic.
     * @param MessageInterface $message the message to be sent
     * @return bool whether the message is sent successfully
     */
    protected function sendMessage($message)
    {
        return mail(
            $message->getTo(),
            $message->getSubject(),
            $message->toString(),
            $message->getHeaders(),
            $message->getAdditional()
        );
    }

} // class Mailer
