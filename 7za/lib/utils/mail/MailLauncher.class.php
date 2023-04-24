<?php
/**
 *  SmartMVC Framework.
 *  Copyright (C) 2004  Alex Koshel <alex@belisar.de>
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with this library; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 *
 */

/**
 * Mail Launcher [<i>utils.mail.MailLauncher</i>].
 *
 * This class is for easy mail sending. You may make an instance of
 * this class within the SmartMVC framework with <i>getClassOf()</i> dispatcher,
 * the name is <i>utils.mail.MailLauncher</i>.
 *
 * Usage example:
 * <code>
 * $mail = $this->getClassOf('utils.mail.MailLauncher');
 * $mail->init('support@microsoft.com', 'What happened?', 'nobody@world.com');
 * $mail->setBody('Please explain', 'text/plain');
 * $mail->send();
 * </code>
 *
 * @package utils
 * @version 0.9 (26/01/2006)
 * @author Alex Koshel <alex@belisar.de>
 */

class MailLauncher {
    /**
    * The body of e-mail.
    *
    * @var      string
    * @access   private
    */
    var $mail_body              = "";

    /**
    * The HTML body of e-mail.
    *
    * @var      string
    * @access   private
    */
    var $html_mail_body         = "";

    /**
    * The array of bodies of e-mail.
    *
    * Every part has it's own content type.
    *
    * @var      array
    * @access   private
    */
    var $bodies                 = array();

    /**
    * "To" address.
    *
    * @var      string
    * @access   private
    */
    var $to_address             = "";

    /**
    * "From" address.
    *
    * @var      string
    * @access   private
    */
    var $from_address           = "";

    /**
    * "Reply-To" address.
    *
    * @var      string
    * @access   private
    */
    var $replyto_address        = "";

    /**
    * "Blind Copy" address.
    *
    * @var      string
    * @access   private
    */
    var $bcc_address            = "";

    /**
    * Subject of the e-mail.
    *
    * @var      string
    * @access   private
    */
    var $subject                = "";

    /**
    * Character set of e-mail.
    *
    * @var      string
    * @access   private
    */
    var $charset                = "windows-1251";

    /**
    * Default content type of e-mail part (text/html or text/plain).
    *
    * @var      string
    * @access   private
    */
    var $content_type           = "text/html";

    /**
    * Default content type of entire e-mail (multipart/alternative or multipart/mixed).
    *
    * @var      string
    * @access   private
    */
    var $global_content_type    = "multipart/mixed";

    /**
    * Number of attachments.
    *
    * @var      integer
    * @access   private
    */
    var $num_attachments        = 0;

    /**
    * Array of attachements.
    *
    * @var      array
    * @access   private
    */
    var $attachments            = array();

     /**
     * Constructor for MailLauncher class.
     *
     * @return MailLauncher
     * @param string $to        "To" address
     * @param string $subj      Subject of the message
     * @param string $from      "From" address
     * @param string $reply     "Reply-To" address
     * @access public
     */
    function MailLauncher( $to = '', $subj = '', $from = '', $reply = '' )
    {
        $this->to_address   = $to;
        $this->from_address = $from;
        if ( empty($reply) )
            $this->replyto_address = $this->from_address;
        else
            $this->replyto_address = $reply;
        $this->bcc_address  = '';
        //$this->charset      = '';
        $this->subject      = $subj;
        $this->num_attachments = 0;
        $this->bodies = array();
    }

     /**
     * Setting initiating options of MailLauncher class.
     *
     * Use this method after you've got the class instance with
     * <i>getClassOf()</i> method.
     *
     * @return void
     * @param string $to        "To" address
     * @param string $subj      Subject of the message
     * @param string $from      "From" address
     * @param string $reply     "Reply-To" address
     * @access public
     */
    function init( $to, $subj = '', $from = '', $reply = '' )
    {
        $this->to_address   = $to;
        $this->from_address = $from;
        if ( empty($reply) )
            $this->replyto_address = $this->from_address;
        else
            $this->replyto_address = $reply;
        $this->bcc_address = '';
        //$this->charset = '';
        $this->subject = $subj;
        $this->num_attachments = 0;
        $this->bodies = array();
    }

     /**
     * Set the message body and it's content type.
     *
     * @return  void
     * @param   string  $body   The text of the message
     * @access  public
     */
    function setBody( $body, $content_type = "text/html" )
    {
        $count = count($this->bodies);
        $this->bodies[$count]["body"] = $body;
        $this->bodies[$count]["content_type"] = $content_type;
    }

     /**
     * Adds an attachement to the mail.
     *
     * @return  void
     * @param   string  $filename   The filename to attach
     * @access  public
     */
    function addAttachment( $filename )
    {
        if ( is_file($filename) )
            $this->attachments[$this->num_attachments++] = $filename;
    }

     /**
     * Sets the BCC address(es).
     *
     * @return  void
     * @param   string  $bcc    The BCC address
     * @access  public
     */
    function setBcc( $bcc )
    {
        $this->bcc_address = $bcc;
    }

     /**
     * Sets the character set of the mail.
     *
     * @return  void
     * @param   string  $cs Charset
     * @access  public
     */
    function setCharset( $cs )
    {
        $this->charset = $cs;
    }


     /**
     * Sets the content type of a text part of a mail.
     *
     * @return void
     * @param unknown $type
     */
    function setContentType( $type = 'text/html' )
    {
        $count = count($this->bodies)-1;
        if ($count >= 0)
            $this->bodies[$count]["content_type"] = $type;
    }

     /**
     * The method for e-mail sending, call it the last.
     *
     * @return  boolean
     * @access  public
     */
    function send()
    {
        $mailheaders = "MIME-Version: 1.0\r\n";
        if ( !empty($this->from_address) )
            $mailheaders .= "From: ".$this->from_address."\r\n";
        if ( !empty($this->replyto_address) )
            $mailheaders .= "Reply-To: ".$this->replyto_address."\r\n";
        if ( !empty($this->bcc_address) )
            $mailheaders .= "Bcc: ".$this->bcc_address."\r\n";

        $mailheaders .= "Content-type: ".$this->global_content_type."; boundary=\"Message-Boundary\"\n";
        $mailheaders .= "X-Mailer: SmartMvc.MailLauncher\n"; //mailer
        $mailheaders .= "X-Priority: 3\n"; //1 UrgentMessage, 3 Normal

        $htmlout = "";
        for ( $i = 0; $i < count($this->bodies); $i++ )
        {
            $htmlout .= "--Message-Boundary\r\n";
            $htmlout .= "Content-Type: ".$this->bodies[$i]["content_type"].";" . (!empty($this->charset)?' charset='.$this->charset:'')."\r\n";
            $htmlout .= "Content-transfer-encoding: 8bit\r\n\r\n";
            $htmlout .= $this->bodies[$i]["body"];
            $htmlout .= "\r\n";
        }

    //    $htmlout = "--Message-Boundary\n";
    //          $htmlout .= "Content-type: text/html; charset=KOI8-U\n";
    //$htmlout .= "Content-Type: text/html; charset=WINDOWS-1251";
    //    $htmlout .= "Content-Type: ".$this->content_type.";".(!empty($this->charset)?' charset='.$this->charset:'')."\n";
    //    $htmlout .= "Content-transfer-encoding: 8bit\n\n";

    //    $htmlout .= $this->mail_body;

        if ( $this->num_attachments > 0 )
        {
            for ( $i = 0; $i < $this->num_attachments; $i++ )
            {
                $htmlout .= "--Message-Boundary\n";
                if ( is_integer(strpos($this->attachments[$i],'/')) )
                    $fname = substr($this->attachments[$i],strrpos($this->attachments[$i],'/')+1);
                else
                    $fname = $this->attachments[$i];
                $htmlout .= "Content-Type: application/octet-stream; name=\"".$fname."\"\n";
                $htmlout .= "Content-Transfer-Encoding: base64\n";
                $htmlout .= "Content-Disposition: attachment; filename=\"".$fname."\"\n\n";
                $fl = fopen($this->attachments[$i], "r");
                $fcontents = fread($fl, filesize($this->attachments[$i]));
                fclose($fl);
                $encoded_attach = chunk_split(base64_encode($fcontents));

                $htmlout .= "$encoded_attach\n\n";
                //$htmlout .= "--Message-Boundary\n";
            }
        }

        $htmlout .= "--Message-Boundary--";

        $from_strict    = "postmaster@" . $_SERVER['HTTP_HOST'];
        //$from_strict    = "postmaster@some.domain";

        if ( $this->charset == "windows-1251" )
            $this->subject = "=?windows-1251?B?" . base64_encode($this->subject) . "?=";
        //if ( @mail( $this->to_address, $this->subject, $htmlout, $mailheaders, "-f" . $from_strict ) )
        if ( @mail( $this->to_address, $this->subject, $htmlout, $mailheaders ) )
            return true;
        else
            return false;

    }

}

?>