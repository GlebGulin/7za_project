<?PHP
class Contacts extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

	var $contact_id					=  0;
	var $title_rus           		= '';
    var $title_ukr           		= '';
    var $email           			= '';
    var $position	           		=  0;
    var $visible					=  0;

    var $name						=  0;
    var $email_sender				= "";
    var $phone						= "";
    var $message					= "";

    var $subject					= "Контактная форма";



/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function Contacts()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

    function getAllContacts()
    {
    	return Contacts::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
    }

    function getContactById($contact_id)
    {
    	$this->contact_id = $contact_id;
    	return Contacts::runQuery( 1, "getArray", __FILE__.":".__LINE__ );
    }

    function visibleContact( $contact_id )
    {
    	$this->contact_id = $contact_id;
    	$item = Contacts::runQuery( 1, "getArray", __FILE__.":".__LINE__ );
    	$this->visible = !$item['visible'];
    	Contacts::runQuery( 2, "none", __FILE__.":".__LINE__ );
    }

    function moveContactUp( $contact_id )
    {
    	$item = $this->getContactById( $contact_id );
    	$this->position = $item["position"];
        $item2 = Contacts::runQuery( 3, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->contact_id  = $item["contact_id"];
            $this->position = $item2["position"];
            Contacts::runQuery( 5, "none", __FILE__ . ':' . __LINE__ );

            $this->contact_id  = $item2["contact_id"];
            $this->position = $item["position"];
            Contacts::runQuery( 5, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    function moveContactDown( $contact_id )
    {
    	$item = Contacts::getContactById( $contact_id );
    	$this->position = $item["position"];
        $item2 = Contacts::runQuery( 4, "getArray", __FILE__ . ':' . __LINE__ );

        if ( $item2 )
        {
            $this->contact_id  = $item["contact_id"];
            $this->position    = $item2["position"];
            Contacts::runQuery( 5, "none", __FILE__ . ':' . __LINE__ );

            $this->contact_id  = $item2["contact_id"];
            $this->position = $item["position"];
            Contacts::runQuery( 5, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    function deleteContact( $contact_id )
    {
    	$this->contact_id = $contact_id;
    	Contacts::runQuery( 6, "none", __FILE__ . ':' . __LINE__ );
    }

    function saveContact( $contact_id )
    {
    	$this->contact_id = $contact_id;
    	Contacts::runQuery( 7, "none", __FILE__ . ':' . __LINE__ );
    }

    function saveNewContact()
    {
    	$this->position = 1 + Contacts::runQuery( 9, "getSingleValue", __FILE__ . ':' . __LINE__ );
    	Contacts::runQuery( 8, "none", __FILE__ . ':' . __LINE__ );
    }

    function getContactsForFrontend( $language )
    {
    	$list = Contacts::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
    	foreach ($list as $key => $value ) {
    		if( $value['visible'] == 0 )
    		{
    			unset( $list[$key] );
    			continue;
    		}

    		$list[$key]["title"] = $value["title_".$language];
    		unset( $list[$key]["title_rus"] );
    		unset( $list[$key]["title_ukr"] );
    	}
    	return $list;
    }

    function checkContactForm()
    {
    	if ( empty($this->name) ||  empty($this->phone) ||
    		 empty($this->subject) || empty($this->message) )
    		return false;
    	return true;
    }

    function sendMail()
    {
        //$contact = $this->getContactById( $this->contact_id );
        //$this->passToTemplate(array( "email" => $contact['email'] ));

        $mailer = $GLOBALS['smtp_mail'];
        $headers['From'] = sprintf("\"=?windows-1251?B?%s?=\" <%s>", base64_encode('Интернет магазин 7ZA'), FROM_EMAIL);
        $headers['MIME-Version'] = '1.0';
        $headers['Content-Type'] = 'text/html; charset="windows-1251"';
        $headers['Content-Transfer-Encoding'] = '8bit';
        $recipients = ADMIN_EMAIL;
        $headers['To'] = $recipients;
        $headers['Subject'] = $this->decodeRequestValue($this->subject);
        if (preg_match("/[\x80-\xFF]/", $headers['Subject'])) $headers['Subject'] = sprintf("=?windows-1251?B?%s?=", base64_encode($headers['Subject']));
        $this->passToTemplate($_POST);
        if ($this->email_sender) $this->passToTemplate(array("email" => $this->email_sender));
        $body = $this->tpl->fetch("mails/contacts.tpl.html");
        $send = $mailer->send($recipients, $headers, $body);

        if (PEAR::isError($send)) {
            return(false);
        } else {
            return(true);
        }

/*
        $mailer =& $this->getClassOf("utils.mail.MailLauncher");
        $mailer->init( ADMIN_EMAIL, $this->decodeRequestValue($this->subject), $this->email_sender ? $this->email_sender : ADMIN_EMAIL);
        $mailer->setCharset("windows-1251");
        $this->passToTemplate($_POST);
        $mailer->setBody($this->tpl->fetch("mails/contacts.tpl.html"));
        $mailer->send();
*/
    }


/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/

    /**
     * wrapper around the runQuery method in dbHandler.class.php
     *
     * requires the appropiate query file for this class and
     * passes the query to dbHandler::runQuery()
     * returns an array or a string in accordance to the wanted result
     * The requirement for query file: it must have filename
     * <classname>.sql.php
     *
     * @author  Ralf Kramer, Alex Koshel
     * @param   int  query_id ( array index of the query within the
     *                          required query file )
     * @param   string result ( specifies the type of the expected
     *          result set
     *          e.g. "getArray", "getIndexArray", "getSingleValue" etc. )
     * @param   msq_id ( a hint that is thrown by the system when an error occurs )
     *
     * @return  mixed
     */
    function runQuery( $query_id, $result, $msg_id )
    {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        return $this->core->runQuery( $query[$query_id], $result, $msg_id );
    }
}
?>