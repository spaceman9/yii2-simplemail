<?php

namespace spaceman9\simplemail;


use yii\mail\BaseMessage;
use yii\mail\MailerInterface;
use yii\mail\MessageInterface;


class php extends BaseMessage
{
    private $charset = "UTF-8";
    private $from;
    private $to;
    private $reply;
    private $cc;
    private $bcc;
    private $subject  = 'SUBJECT:';
    private $text = '';
    private $html = '';
    private $attachment = [];


    /**
     * Returns the character set of this message.
     * @return string the character set of this message.
     */
    public function getCharset()
    {
        return $this->charset;
    }


    /**
     * Sets the character set of this message.
     * @param string $charset character set name.
     * @return $this self reference.
     */
    public function setCharset( $charset )
    {
        $this->charset = $charset;
    }


    /**
     * Returns the message sender.
     * @return string|array the sender
     */
    public function getFrom()
    {
        return $this->from;
    }


    /**
     * Sets the message sender.
     * @param string|array $from sender email address.
     * You may pass an array of addresses if this message is from multiple people.
     * You may also specify sender name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setFrom( $from )
    {
        $this->from = $from;
    }


    /**
     * Returns the message recipient(s).
     * @return string|array the message recipients
     */
    public function getTo()
    {
        return $this->to;
    }


    /**
     * Sets the message recipient(s).
     * @param string|array $to receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setTo( $to )
    {
        $this->to = $to;
    }


    /**
     * Returns the reply-to address of this message.
     * @return string|array the reply-to address of this message.
     */
    public function getReplyTo()
    {
        return $this->reply;
    }


    /**
     * Sets the reply-to address of this message.
     * @param string|array $replyTo the reply-to address.
     * You may pass an array of addresses if this message should be replied to multiple people.
     * You may also specify reply-to name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setReplyTo( $replyTo )
    {
        $this->reply = $replyTo;
    }


    /**
     * Returns the Cc (additional copy receiver) addresses of this message.
     * @return string|array the Cc (additional copy receiver) addresses of this message.
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Sets the Cc (additional copy receiver) addresses of this message.
     * @param string|array $cc copy receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
    }

    /**
     * Returns the Bcc (hidden copy receiver) addresses of this message.
     * @return string|array the Bcc (hidden copy receiver) addresses of this message.
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Sets the Bcc (hidden copy receiver) addresses of this message.
     * @param string|array $bcc hidden copy receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
    }


    /**
     * Returns the message subject.
     * @return string the message subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the message subject.
     * @param string $subject message subject
     * @return $this self reference.
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Sets message plain text content.
     * @param string $text message plain text content.
     * @return $this self reference.
     */
    public function setTextBody($text)
    {
        $this->text = $text;
    }

    /**
     * Sets message HTML content.
     * @param string $html message HTML content.
     * @return $this self reference.
     */
    public function setHtmlBody($html)
    {
        $this->html = $html;
    }

    /**
     * Attaches existing file to the email message.
     * @param string $fileName full file name
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return $this self reference.
     */
    public function attach($fileName, array $options = [])
    {
        $name = md5($fileName);
        $this->attachment[$name] = $options + ['filename' => $fileName];
    }

    /**
     * Attach specified content as file for the email message.
     * @param string $content attachment file content.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return $this self reference.
     */
    public function attachContent($content, array $options = [])
    {
        $name = md5($content);
        $this->attachment[$name] = $options + ['content' => $content];
    }

    /**
     * Attach a file and return it's CID source.
     * This method should be used when embedding images or other data in a message.
     * @param string $fileName file name.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return string attachment CID.
     */
    public function embed($fileName, array $options = [])
    {
        $name = md5($fileName);
        $this->attachment[$name] = $options + ['filename' => $fileName];
        return "CID:$name";
    }

    /**
     * Attach a content as file and return it's CID source.
     * This method should be used when embedding images or other data in a message.
     * @param string $content attachment file content.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return string attachment CID.
     */
    public function embedContent($content, array $options = [])
    {
        $name = md5($content);
        $this->attachment[$name] = $options + ['content' => $content];
        return "CID:$name";
    }

    /**
     * Sends this email message.
     * @param MailerInterface $mailer the mailer that should be used to send this message.
     * If null, the "mailer" application component will be used instead.
     * @return bool whether this message is sent successfully.
     */
    //public function send(MailerInterface $mailer = null);

    /**
     * Returns string representation of this message.
     * @return string the string representation of this message.
     */
    public function toString()
    {
        return '';
    }

} // Message
