<?PHP
/**
 *  SmartMVC Framework.
 *  Copyright (C) 2004  Belisar Systems
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
 * The class for debugging purposes.
 *
 * This class is a part of SmartMVC framework.
 *
 * @version 0.2 (19/04/2004)
 * @package SmartMVC
 * @author Ralf Kramer <rk@belisar.de>
 * @author Alex Koshel <alex@belisar.de>
 */

class debugHandler 
{

##=================================================================================##  
##                  MEMBER - VARIABLES                                             ##
##=================================================================================## 

	/**
	* Contains debug messages.
	*
	* @var     string
	* @access  public
	*/
    var $debugMsg                               = "@";

	/**
	* Contains messages for current page.
	*
	* @var     string
	* @access  public
	*/
    var $pageMsg                                = "";
    
    /**
	* Specifies the debug mode ("screen", "email" or "noAction").
	*
	* If you need to change the debug manner set the value of
	* DEBUG_MODE constant in config.inc.php file.<br>
	* Possible values are "screen", "email" and "noAction". The "screen"
	* value used for the message output to the screen, useful during
	* the development.
	*
	* @var     string
	* @access  public
	*/
    var $debugMode                              = DEBUG_MODE;

	/**
     * Accumulates values of variables for debugging.
     *
     * @var     string
     */
    var $debugVars                              = "";
    
    /**
	* Sets the proceeding way after error occured.
	*
	* Set it to <i>true</i> if you want the application terminated
	* when error occured.
	*
	* @var     boolean
	* @access  public
	*/
    var $haltOnError                            = FALSE;

    /**
	* Contains e-mail address for sending debug messages there.
	*
	* Has sense only when DEBUG_MODE is "email".
	*
	* @var     string
	* @access  public
	*/
    var $mail4debug                             = MAIL_4_DEBUG;

    /**
	* Contains relative or absolute link of the page which will be 
	* displayed after error occured.
	*
	* Has sence only if {@link $debugMode} is "email".
	*
	* @var     string
	* @see     $debugMode
	*/
    var $errorPage                              = ERROR_PAGE;

    /**
	* Specifies whether to include variables dump in debug message.
	*
	* @var     boolean
	* @access  public
	*/
    var $addDebugVars                           = TRUE;

	/**
	* Contains starting value of the timer.
	*
	* @var     float
	* @access  public
	*/
    var $timerStart;

    /**
	* Contains finish value of the timer.
	*
	* @var     float
	* @access  public
	*/
    var $timerEnd;

	/**
	*
	* @var     boolean
	* @ignore
	*/
    var $displayResults;

##=================================================================================##  
##                  INITIALIZATION                                                 ##
##=================================================================================## 

	/**
	* Constructor of the class.
	*
	* @return debugHandler
	*/
	function debugHandler(  ) 
    {	
	}

##=================================================================================##  
##                  DEBUG OUTPUT HANDLE                                            ## 
##=================================================================================##   

	/**
	* Adds a new message to $this->debugMsg and process with member
	* function according to $this->debugMode.
	*
	* @return  void
	* @access  public
	* @param   string  $msg    The message text
	* @param   string  $id     ID of the message
	*/
	function addDebugMsg( $msg, $id )
	{
		$this->debugMsg .= $msg . "@";				// add message, the @ char is a seperator
		$debugMode = $this->debugMode;
		$this->msgID = $id;
		$this->$debugMode();
	}    

	/**
	* Useful to accumulate $this->debugMsg for later purposes without fire an event.
	*
	* Used by {@link addDebugMsg()} method.
	*
	* @return void
	* @ignore
	*/
	function noAction()
	{
	}

	/**
	* Prints the debugMessage on the screen and terminates.
	*
	* Used by {@link addDebugMsg()} method.
	*
	* @ignore
	* @return void
	*/
	function screen()
	{
		$this->debugMsg = str_replace( "@", "<br>", $this->debugMsg );
        if( $this->addDebugVars )
            $this->debugMsg .= $this->debugVars;
		echo $this->debugMsg;
		echo "<br>DEBUG_MODE is " . $this->debugMode;
		echo "<br>Message ID:" . $this->msgID;
        die;
	}

	/**
	* Sends only a mail to $this->mail4debug and dies.
	*
	* Used by {@link addDebugMsg()} method.
	*
	* @ignore
	* @return void
	*/
	function email()
	{
		$this->debugMsg  = str_replace( "@", "\n", $this->debugMsg );
		$this->debugMsg .= "\n DEBUG_MODE is " . $this->debugMode;
		$this->debugMsg .= "\n Message ID:" . $this->msgID;

        if( $this->addDebugVars )
            $this->debugMsg .= $this->debugVars;

		$server = getenv( "SERVER_NAME" );

		$headers  = "From: DebugMessage <debugger@$server\n";
		$headers .= "X-Sender: <debugmailer@$server>\n";
		$headers .= "X-Mailer: debugFunction v1\n"; //mailer
		$headers .= "X-Priority: 1\n"; //1 UrgentMessage, 3 Normal

		@mail( $this->mail4debug, "error@" . $server . " ID: " . $this->msgID, $this->debugMsg , $headers );

        $this->proceedOnError();
	}

##=================================================================================##    
##					TIMER                                                          ##
##=================================================================================## 

    /**
    * Computes the current time into such format: 1030728128.2405.
    *
    * @return   float
    * @access   public
    */
    function getMicroTime()
    {
        list($usec, $sec) = explode(" ",microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
    * Starts the timer.
    *
    * @return   void
    * @access   public
    */
    function startTimer()
    {
       $this->timerStart = $this->getMicroTime();
    }

    /**
    * Stops the timer.
    *
    * @return   void
    * @access   public
    */
    function stopTimer()
    {
       $this->timerEnd = $this->getMicroTime();
    }

    /**
    * Displays the execution time on screen.
    *
    * @return   void
    * @access   public
    */
    function displayTimer()
    {
       $execution_time = $this->getExecutionTime();
       echo "<br>=======================Timer=======================<br>";
       echo "time to execute is <b>$execution_time</b> sec" ;
       echo "<br>=======================/Timer=======================<br>";
    }

    /**
    * Returns the computed execution time.
    *
    * @return   float
    * @access   public
    */
    function getExecutionTime()
    {
       return $execution_time = $this->timerEnd - $this->timerStart;
    }

##=================================================================================##    
##					REDIRECT                                                       ##
##=================================================================================##   

    /**
    * Redirects browser to the specified <i>$target</i> with parameters in
    * <i>$params</i> (empty by default).
    *
    * @return   void
    * @access   public
    * @param    string  $target
    * @param    string  $params
    */
    function redirect( $target, $params = '' )
    {
        if( !empty( $params ) )
            $params = "?" . $params;

        $url = $target . $params;
        header( "Location: " . $url );
        die;
    }

##=================================================================================##    
##					MESSAGE                                                        ##
##=================================================================================##

    /**
    * Adds a message for the page.
    *
    * @return   void
    * @access   public
    * @param    string  $msg
    * @param    string  $line_break
    */
    function addPageMsg( $msg, $line_break="<br>" )
    {
        $this->pageMsg .= $msg . $line_break;
    }

    /**
    * Returns the debug message.
    *
    * @return   string
    * @access   public
    */
    function getPageMsg()
    {
        return  $this->pageMsg;
    }

    /**
    * Displays the debug message.
    *
    * @return   void
    * @access   public
    */
    function displayPageMsg()
    {
        echo $this->getPageMsg();
    }

##=================================================================================##    
##					HELPER - FUNCTIONS                                             ##
##=================================================================================##      

    /**
    * Disables outputting of var dump in messages.
    *
    * @return   void
    * @access   public
    */
    function disableDebugVars()
    {
        $this->addDebugVars   = FALSE;
    }

    /**
    * Returns a var dump as $var without displaying on the screen.
    *
    * @return   string
    * @access   public
    * @param    string  $var
    */
    function getVarDump( $var ) 
    {
        ob_start();
        var_dump($var);
        $ret_val = ob_get_contents();
        ob_end_clean();

        return $ret_val;
    }

    /**
	* Show only a var_dump for one var.
    *
    * @return   void
    * @access   public
    * @param    string  $var
    */
	function showVarDump( $var )
	{
        echo "<br>=========================================================================";
        echo "<h1>var_dump for $$var</h1>";
        echo var_dump( $var );
        echo "<br>=========================================================================<br>";
	}

    /**
    * Describes the way of proceeding after an error occured.
    *
    * @return void
    */
    function proceedOnError()
    {
        // stop system if desired
        if( $this->haltOnError )
        {
		    die;
        }

        else // clear debugMsg and display error page
        {
            $this->debugMsg = "@";
            if (!empty($this->errorPage))
                $this->redirect( $this->errorPage );
        }
    }

    /**
    * Use this method to see what happens after executing the page.
    *
    * Useful when debugMode set to "noAction".
    *
    * @return void
    */
    function displayDebugMessage()
    {
       echo $this->debugMsg;
    }

} // End debugHandler

?>