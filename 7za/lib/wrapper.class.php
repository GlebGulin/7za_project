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
 * Wrapper class for all main features of the framework.
 *
 * @package SmartMVC
 * @version 1.02 (10/05/2005)
 * @author Alex Koshel <alex@belisar.de>
 */

class wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    /**
     * Contains handler for resource bundle.
     *
     * On the initialization stage this variable assigned to
     * the array containing options from project's config file.
     *
     * @var array
     */
    var $rb                 = "";
    var $core               = "";

    var $tpl                = "";
    var $tplToDisplay       = "";
    var $makeURLHashes      = false;
    var $lang               = "";
    var $sm                 = "";
    var $smIndex            = "";
    var $smLimitClause      = "";
    var $coreVars           = array();
    /**
    * SmartTimePeriod holder.
    *
    * Use function $this->initSmartTimePeriod() for initialization. After this call
    * $this->stp variable will contain SmartTimePeriod instance.
    *
    * @var  class
    */
    var $stp                = "";
    /**
    * Request class container.
    *
    * @var  class
    */
    var $request            = "";
    /**
    * Specified whether URL hashing is mandatory for current controller.
    *
    * Override this variable in your controller classes with default value
    * of <i>true</i> if URL hashing is required.
    *
    * @see  makeURLHashes()
    * @var  boolean
    */
    var $checkURLHash       = false;

    /**
    * Application name.
    *
    * @var  string
    */
    var $applicationName    = "";

    /**
    * Whether to encode request arrays to prevent XSS attack.
    *
    * @var  boolean
    */
    var $encodeRequestArrays    = false;

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * Construtor for the class.
     *
     * @author  Alex Koshel
     */
    function wrapper()
    {
        global $core;
        $this->core = &$core;

        if ( $this->encodeRequestArrays )
            $this->core->preventXssAttack();

        $this->request          = &$this->core->request;
        $this->tpl              = &$this->core->tpl;
        $this->tplToDisplay     = &$this->core->tplToDisplay;
        $this->makeURLHashes    = &$this->core->makeURLHashes;
        $this->checkURLHash     = &$this->core->checkURLHash;
        $this->rb               = &$this->core->rb;
        $this->lang             = &$this->core->lang;
        $this->sm               = &$this->core->sm;
        $this->smIndex          = &$this->core->smIndex;
        $this->smLimitClause    = &$this->core->smLimitClause;
        $this->stp              = &$this->core->stp;
        $this->request          = &$this->core->request;
        // making application name unique per script execution
        if ( !empty($this->applicationName) )
            $this->core->applicationName = $this->applicationName;
        $this->applicationName  = &$this->core->applicationName;

        $this->addCoreVars(array_keys(get_class_vars("wrapper")));
    }

/****************************************************************************
 *               Wrapper functions for debug features                       *
 ****************************************************************************/

 	/**
	* Adds a new message to $this->debugMsg and process with member
	* function according to $this->debugMode.
	*
	* @return  void
	* @access  public
	* @param   string  $msg    The message text
	* @param   string  $id     ID of the message
	*/
	function &addDebugMsg( $msg, $id )
	{
	    return $this->core->addDebugMsg( $msg, $id );
	}

    /**
    * Starts the timer.
    *
    * @return   void
    * @access   public
    */
    function startTimer()
    {
        $this->core->startTimer();
    }

    /**
    * Stops the timer.
    *
    * @return   void
    * @access   public
    */
    function stopTimer()
    {
        $this->core->stopTimer();
    }

    /**
    * Displays the execution time on screen.
    *
    * @return   void
    * @access   public
    */
    function displayTimer()
    {
        $this->core->displayTimer();
    }

    /**
    * Returns the computed execution time.
    *
    * @return   float
    * @access   public
    */
    function &getExecutionTime()
    {
        return $this->core->getExecutionTime();
    }

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
        $this->core->redirect( $target, $params );
    }

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
        $this->core->addPageMsg( $msg, $line_break );
    }

    /**
    * Returns the debug message.
    *
    * @return   string
    * @access   public
    */
    function &getPageMsg()
    {
        return $this->core->getPageMsg();
    }

    /**
    * Displays the debug message.
    *
    * @return   void
    * @access   public
    */
    function displayPageMsg()
    {
        $this->core->displayPageMsg();
    }

    /**
    * Disables outputting of var dump in messages.
    *
    * @return   void
    * @access   public
    */
    function disableDebugVars()
    {
        $this->core->disableDebugVars();
    }

    /**
    * Returns a var dump as $var without displaying on the screen.
    *
    * @return   string
    * @access   public
    * @param    string  $var
    */
    function &getVarDump( $var )
    {
        return $this->core->getVarDump( $var );
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
	    $this->core->showVarDump( $var );
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
        $this->core->displayDebugMessage();
    }

/****************************************************************************
 *               Wrapper functions for working with DB                      *
 ****************************************************************************/

    /**
    * Sets the status whether to output following SQL queries
    * before their execution.
    *
    * @return void
    * @param boolean $status
    */
    function displayQueries( $status = true )
    {
        $this->core->displayQueries( $status );
    }

    /**
    * Shortcut for {@link displayQueries()} method for faster access.
    *
    * @return void
    * @param boolean $status
    */
    function dq( $status = true ) {
        $this->displayQueries( $status );
    }

    /**
    * The function for getting key of last inserted record.
    * Returns the value of the AUTO_INCREMENT column from the last
    * inserted record.
    *
    * @return integer
    */
    function lastInsertId()
    {
        return $this->core->lastInsertId();
    }

    /**
     * Gets the next auto_increment value from a table.
     *
     * @param   string  $table
     * @return  int     the value of the next auto_increment
     * @access public
     * @todo check whether you need to lock this table
     * @author  Ralf Kramer <rk@belisar.de>
     */
    function getNextAutoIncrement( $table )
    {
        return $this->core->getNextAutoIncrement( $table );
    }

    /**
     * Returns the table status array.
     *
     * @param   string  $table
     * @return  array
     * @access  public
     * @author  Ralf Kramer <rk@belisar.de>
     */
    function &getTableStatus( $table )
    {
        return $this->core->getTableStatus( $table );
    }

   /**
    * Outputs the number of executed queries.
    *
    * @return void
    */
    function displayQueryCounter()
    {
        $this->core->displayQueryCounter();
    }

   /**
    * Returns the number of executed queries.
    *
    * @return int
    */
    function getQueryCounter()
    {
        return $this->core->getQueryCounter();
    }

    /**
    * Outputs on the screen the specified SQL query with
    * highlighted syntax.
    *
    * @return void
    * @param string $query
    * @param string $queryID
    */
    function displayQuery( $query, $queryID )
    {
        $this->core->displayQuery( $query, $queryID );
    }

/****************************************************************************
 *                  Wrapper functions for main class                        *
 ****************************************************************************/

    /**
     * The dispatcher method.
     *
     * Use it for searching classes from the SmartMVC library or your
     * own model classes. It takes as the argument the full
     * name of necessary class and returns the instance of it.
     *
     * <b>NOTE:</b> Uses the Singleton Design Pattern, keep this in mind
     * if any side effects appear.
     *
     * @author  Alex Koshel
     * @access  public
     * @return  class
     * @todo    add a switch which allows to disable the singleton functionality
     * @param   string  $fullClassName  The name of required class.
     * @param   array   $import         Array to be imported into the class
     */
    function &getClassOf( $fullClassName, $import = false )
    {
        $class =  $this->core->getClassOf( $fullClassName, $import );
        return $class;
    }

    /**
     * A factory method for model classes.
     *
     * - Creates of $class_name<br>
     * - executes $class_name->$method_name with params
     *
     * @param  string $class_name
     * @param  string $method_name
     * @param  array  $params
     * @return mixed
     * @access public
     * @author Ralf Kramer <rk@belisar.de>
     */
    function &modelFactory( $class_name, $method_name, $params = array() )
    {
        error_reporting(0);
	    $class = $this->core->modelFactory( $class_name, $method_name, $params );
	    error_reporting(15);
        return $class;

    }

    /**
     * Loads the specified associative array into the current class.
     *
     * @author  Alex Koshel
     * @return  void
     * @param   array   $ary
     * @access  public
     */
    function importIntoClass( $ary )
    {
        if (is_array($ary))
        {
            foreach ($ary as $key=>$value)
                if (method_exists($this, "existCoreVar"))
                {
                    if ($key == "smIndex" || !$this->existCoreVar($key)) $this->$key = $value;
                    else $this->addDebugMsg("You cannot use \$$key membervar, it used by SmartMVC core", "importIntoClass()");
                }
                else $this->addDebugMsg("You cannot use importIntoClass() method on not model classes", "importIntoClass()");;
        }
        else
            $this->importIntoClass($this->request->data($ary));
    }

    /**
     * Adds core vars to avoid rewriting of SmartMVC core membervars.
     *
     * @author  Alex Koshel
     * @param   array   $vars       One-dimensional array of names (or single name)
     * @return  void
     * @access  public
     */
    function addCoreVars( $vars )
    {
        if (is_array($vars))
            foreach ($vars as $var)
                $this->addCoreVars($var);
        else
        {
            if (!in_array($vars, $this->coreVars))
                $this->coreVars[] = $vars;
        }
    }

    /**
     * Checks whether the variable is a SmartMVC core member.
     *
     * @author  Alex Koshel
     * @param   string  $var
     * @return  boolean
     * @access  public
     */
    function existCoreVar( $var )
    {
        if (in_array($var, $this->coreVars))
            return true;
        else
            return false;
    }

    /**
     * Loads the language file into the class.
     *
     * @author  Alex Koshel
     * @return  void
     * @param   string  $langFile   The name of language file
     */
    function loadLanguageFile( $langfile )
    {
        return $this->core->loadLanguageFile( $langfile );
    }

    /**
     * Loads the conf file and applies it's contents to $this->rb.
     *
     * This method invoked within the constructor of main class.
     *
     * @author  Ralf Kramer
     * @author  Alex Koshel
     * @return  true
     */
    function &loadResourceBundle()
    {
        return $this->core->loadResourceBundle();
    }

    /**
     * Wrapper around the SplitMenu class - allows easy access within the entire app.
     *
     * The splitMenu class builds navigation elements that allows to browse through big
     * result set. These navigation elements looks usually like this:
     * << 1 2 3 4 >> where each char is a link to a page that displays a cutout of a
     * big result set. In the very most applications the appearance of this split menus
     * is system wide the same. So if you wish to use alternate values for the appearance
     * e.g. "<<" on one page and "back" on another page you need to adapt this method or
     * overwrite it.
     *
     * @param   string $target_url url or filename of the pages
     * @param   int    $index_length how many records should be displayed
     * @param   int    $data_elements how many records has the query
     * @param   string $params params that where added to each link
     * @author  Ralf Kramer
     * @return  void
     */
    function &initSplitMenu( $target_url, $index_length, $data_elements, $params = "" )
    {
        error_reporting(0);
        $sm = $this->core->initSplitMenu($target_url, $index_length, $data_elements, $params);
        error_reporting(15);
        return $sm;
    }

    /**
    * This method prepares and outputs the template for the SQL query.
    *
    * You must specify the table name, for which you are going to run a SQL query
    * and an operation type (insert|delete|update|select). After running this method you
    * will get the template of a SQL query on the screen, copy&paste it to query file
    * or do whatever you want with it ;-).
    *
    * @return   void
    * @param    string  $table          table name
    * @param    string  $operation      Type of an operation: insert|delete|update|select
    */
    function queryProposal( $table, $operation = "select" )
    {
        return $this->core->queryProposal($table, $operation);
    }

    /**
    * Shortcut to queryProposal().
    *
    * @see      queryProposal()
    * @return   void
    * @param    string  $table          table name
    * @param    string  $operation      Type of an operation: insert|delete|update|select
    */
    function qp( $table, $operation = "select" )
    {
        return $this->core->queryProposal($table, $operation);
    }

    /**
     * Set common headers to avoid caching.
     *
     * @return void
     * @access public
     * @author Ralf Kramer <rk@belisar.de>
     */
    function setDontCacheHeaders()
    {
        $this->core->setDontCacheHeaders();
    }

    /**
     * Returns the reference table ready for passing to template.
     *
     * @return array
     * @param   string  $table          table name
     * @param   string  $key_field      the name of a key field
     * @param   string  $value_field    the name of a value field
     * @access public
     * @author Alex Koshel <alex@belisar.de>
     */
    function &getReferenceTable( $table, $key_field = "id", $value_field = "value", $order_field = "" )
    {
        return $this->core->getReferenceTable($table, $key_field, $value_field, $order_field);
    }

    /**
     * Returns an array item by name.
     *
     * The shortcut for Request::validateParam() function.
     *
     * @return  mixed
     * @param   array   $ary
     * @param   string  $name
     * @param   string  $type   required type of an item
     */
    function getParam( $ary, $name, $type )
    {
        return $this->request->validateParam($ary, $name, $type);
    }

    /**
     * Displays the content of a 2 dimensional array as table.
     *
     * This dirty method is intended for development purposes only.
     * It renders the keys of the first record as <th>.
     *
     * @param   array  $data 2-Dim array
     * @author  Ralf Kramer
     * @return  void
     */
    function displayRecords( $data )
    {
        $this->core->displayRecords( $data );
    }

    /**
    * Shortcut for {@link displayRecords()} for faster access.
    *
    * @return void
    * @param array $data
    */
    function dr( $data )
    {
        $this->core->displayRecords( $data );
    }

    /**
    * Outputs 1-Dim array as a table.
    *
    * Use this method for debugging purposes only.
    *
    * @return boolean
    * @param array $data 1-Dim array
    */
    function displayArray( $data )
    {
        $this->core->displayArray( $data );
    }

    /**
    * Shortcut for {@link displayArray()} method for faster access.
    *
    * @return void
    * @param array $data
    */
    function da( $data )
    {
        $this->core->displayArray( $data );
    }

    /**
     * Fills any value with leading zeros.
     *
     * @author  Ralf Kramer
     * @param   string  $val
     * @param   integer $length max lenght of return value
     * @return  string
     */
    function &zerofill( $val, $length )
    {
        return $this->core->zerofill( $val, $length );
    }

    /**
     * Returns the type of a file by its extension.
     *
     * This method does not check whether the passed <i>$file</i> is really
     * a file. It only and simply returns the last fileextension if
     * there one which is indicated by a dot. If no dot is found it
     * returns false.
     *
     * @param  string $file the url or path to the file
     * @return string the file type
     * @access public
     * @author Ralf Kramer <rk@belisar.de>
     */
    function &getFileType( $file )
    {
        return $this->core->getFileType( $file );
    }

    /**
     * Wrapper around $this->request->validateRequest
     *
     * @param  string $request_tpye [GET|POST]
     * @param  string $var_name
     * @param  string $var_type [int|string]
     * @return boolean
     * @author Ralf Kramer <rk@belisar.de>
     */
    function isValidVar( $request_tpye, $var_name, $var_type )
    {
        return $this->core->isValidVar( $request_tpye, $var_name, $var_type );;
    }


/****************************************************************************
 *                  Wrapper functions for page class                        *
 ****************************************************************************/

    /**
     * Parses section of language file and passes it to template engine.
     *
     * @author  Alex Koshel
     * @return  void
     * @param   array   $values The associative array
     */
    function parseLanguagePage( $values )
    {
        $this->core->parseLanguagePage( $values );
    }

    /**
    * Passes specified associative array to the template engine.
    *
    * @return void
    * @param    array   $values     associative array to be passed to TE
    */
    function passToTemplate( $values )
    {
        $this->core->passToTemplate( $values );
    }

    /**
     * Generates HTML form and outputs it on the screen.
     *
     * @return   void
     * @param    string     $xml_file
     * @param    boolean    $smarty_code    whether to insert smarty code
     * @access   public
     */
    function &generateForm( $xml_file, $smarty_code = true )
    {
        return $this->core->generateForm( $xml_file, $smarty_code );
    }

    /**
     * Generates JS validation script for the form by XML form template.
     *
     * JS code passed to Smarty in js_validation variable.
     *
     * @return   void
     * @param    string     $xml_file
     * @param    string     $error_msg  the error message shown on fault
     * @access   public
     */
    function makeJSValidation( $xml_file, $error_msg )
    {
        return $this->core->makeJSValidation($xml_file, $error_msg);
    }

    function initEditor($form_item_name, $init_value = "", $smarty_var_name = "editor_code")
    {
    	$Editor =& $this->getClassOf("Modules.Editor");
        $Editor->setInputName($form_item_name);
        $Editor->setValue($init_value);
        $this->tpl->assign($smarty_var_name,$Editor->createHtml());
    }

    function getEditorCode($form_input_name)
    {
    	$text = $this->getParam("POST", $form_input_name , "string");
        return str_replace("'", "\'",$this->decodeRequestValue($text));
    }

/****************************************************************************
 *                      SimpleCounter class wrapper                         *
 ****************************************************************************/

    function countHitForArea( $area )
    {
        $this->core->countHitForArea( $area );
    }

    function &getCounterStatsPage()
    {
        return $this->core->getCounterStatsPage();
    }

    function &getCounterStats()
    {
        return $this->core->getCounterStats();
    }

    /**
     * Encoding all request arrays for preventing XSS attack.
     *
     * @return   void
     * @param    string     $filter     the name of a filter
     * @access   public
     */
    function preventXssAttack( $filter = "common" )
    {
        return $this->core->preventXssAttack( $filter );
    }

    /**
     * Reverse operation for encoding against XSS attacks.
     *
     * @return   string
     * @param    string     $value
     * @access   public
     */
    function decodeRequestValue( $value )
    {
        return $this->core->decodeRequestValue( $value );
    }

/****************************************************************************
 *                      URLs hashing feature                                *
 ****************************************************************************/

    /**
     * Explores output of the template engine and inserts URL hashes
     * if necessary.
     *
     * URLs hashing feature lets you secure your GET request line from
     * changing it on client side. For example your request looks like:<br>
     * http://site.com/articles.php?article_id=15&print_view=1<br>
     * and you need to be sure that article_id param in request came
     * unchanged to the server, i.e. forbid the client to change this
     * value which was generated by another page of your site.
     *
     * The solution is simple. You just add the param <i>url_hash</i> to
     * the end of your request line for this page like following:<br>
     * http://site.com/articles.php?article_id=15&print_view=1&url_hash<br>
     * and turn on URLs hashing feature by setting {@link makeURLHashes} to
     * <i>true</i> in a controller that outputs a page with this link.
     * SmartMVC framework itself will explore the resulting output of a
     * template engine and insert hashes, so the link above will look as:<br>
     * http://site.com/articles.php?article_id=15&print_view=1&url_hash=HW6Z9LFQRT
     *
     * In the controller of articles.php you define the member var {@link checkURLHash}
     * with default value of <i>true</i> that means to check passed hash value for
     * corresponding to request line. If hash is right then this means that your
     * request line came unchanged. If it's not right or hash is absent at all the
     * controller redirects client to a page with error message.
     *
     * @author  Alex Koshel
     * @idea    Ralf Kramer
     * @return  string
     * @param   string  $output
     */
    function &makeURLHashes( $output )
    {
        return $this->core->makeURLHashes( $output );
    }

    /**
    * Gets compiled output and inserts URL hashes where needed, then outputs
    * all that stuff.
    *
    * @return   void
    * @param    string  $tpl
    */
    function makeHashesAndDisplay( $tpl )
    {
        $this->core->makeHashesAndDisplay( $tpl );
    }

    /**
     * Method for displaying the template.
     *
     * This method called automatically and intended for displaying the template
     * the filename of which stored in $tplToDisplay variable.
     * Note, that <i>display()</i> method is intended for use of Smarty template
     * engine.
     *
     * @return  boolean
     */
    function &display()
    {
        error_reporting(0);
        $display = $this->core->display();
        error_reporting(15);
        return $display;
    }

/****************************************************************************
 *                      utilities                                           *
 ****************************************************************************/

    /**
    * Wrapper around the SmartTimePeriod tool, allows easy access within entire app.
    *
    * For details see API docs for SmartTimePeriod class.
    *
    * @return void
    * @param    mixed   $startDate
    * @param    mixed   $endDate
    */
    function initSmartTimePeriod($startDate = '', $endDate = '')
    {
        $this->core->initSmartTimePeriod($startDate, $endDate);
    }

   /**
     * Returns a list of mandatory form fields separated by space.
     *
     * @return   string
     * @param    string $xml_file
     * @access   public
     */
    function getMandatoryFields( $xml_file )
    {
        return $this->request->getMandatoryFields( $xml_file );
    }

/****************************************************************************
 *                    String utility functions                              *
 ****************************************************************************/

    /**
     * turns a string into an array
     *
     * The string must have this format @23@232@434@
     * @ is the delimiter in this case.
     * It is important that the string begins and
     * ends with a $delimiter
     *
     * @param   string  $string
     * @param   string  $delimiter
     * @return  array
     * @access  public
     * @author  Ralf Kramer <kramer@ebimos.com>
     */
    function stringToArray( $string, $delimiter = "@")
    {
        return $this->core->stringToArray( $string, $delimiter );
    }

    /**
     * Turns an array to a string, seperated by $delimter
     *
     * This is used when we need to store categories in
     * a checkbox representation. Checked checkboxes are
     * stored in this manner @12@14@15@
     *
     * @param   array  $data_array
     * @param   array  $delimter
     * @return  string
     * @access  public
     * @author  Kramer <kramer@ebimos.com>
     */
    function arrayToString( $data_array, $delimter = "@" )
    {
        return $this->core->arrayToString( $data_array, $delimter );
    }
    
    function sefuPrepare( $string )
    {
        $string = preg_replace("/&#[0-9]+;/", "-", $string);
        $string = str_replace(" ", "-", strtolower(html_entity_decode($string)));
        $string = preg_replace("/[^a-z0-9\-]/", "", $string);
        while ( is_integer(strpos($string, "--")) )
        	$string = str_replace("--", "-", $string);

        // replace '-' in start of string
        if ( strlen($string) > 0 && $string{0} == "-" )
            $string = substr($string, 1);

        // replace '-' in end of string
        if ( strlen($string) > 0 && $string{strlen($string)-1} == "-" )
            $string = substr($string, 0, strlen($string)-1);

        return $string;
    }

    function sefuPrepareArray( $array, $field_name, $sefu_field = "sefu_title" )
    {
        if ( !is_array($array) )
            return false;

        if ( empty($array) )
            return false;

        foreach ( $array as $key => $value )
            $array[$key][$sefu_field] = $this->sefuPrepare($value[$field_name]);

        return $array;
    }
    

/****************************************************************************
 *                      Handling with the Registry                          *
 ****************************************************************************/

    /**
     * Sets a value to Registry.
     *
     * @return   void
     * @param    string     $module
     * @param    string     $name
     * @param    mixed      $value
     * @access   public
     * @author   Alex Koshel <alex@belisar.de>
     */
    function setOption( $module, $name, $value )
    {
        return $this->core->modelFactory( "Modules.Registry", "setValue", array($module, $name, $value) );
    }

    /**
     * Returns a value from the Registry.
     *
     * @return   mixed
     * @param    string     $module
     * @param    string     $name
     * @access   public
     * @author   Alex Koshel <alex@belisar.de>
     */
    function getOption( $module, $name )
    {
        return $this->core->modelFactory( "Modules.Registry", "getValue", array($module, $name) );
    }

/****************************************************************************
 *                          CRUD wrapper functions                          *
 ****************************************************************************/

    /**
     * A function for getting the record from specified table by its ID.
     *
     * @param   mixed   $id
     * @param   string  $table_name
     * @return  array
     */
    function getItemById( $id, $table_name )
    {
        $CRUD =& $this->getClassOf("db.mysql.CRUD");
        return $CRUD->getItemById( $id, $table_name );
    }

    /**
     * Removes a record from a specified table and with specified ID.
     *
     * @param   mixed   $id
     * @param   string  $table_name
     * @return  int
     */
    function deleteItem( $id, $table_name )
    {
        $CRUD =& $this->getClassOf("db.mysql.CRUD");
        return $CRUD->deleteItem( $id, $table_name );
    }

    /**
     * Inserts new record into the specified table.
     *
     * This method takes the data from $data array (second parameter). If this parameter
     * not specified data taken from a POST array.
     *
     * Returns an ID of just added record.
     *
     * @param   string  $table_name
     * @param   array   $data
     * @return  int
     */
    function addItem( $table_name, $data = false )
    {
        $CRUD =& $this->getClassOf("db.mysql.CRUD");
        return $CRUD->addItem( $table_name, $data );
    }

    /**
     * Updates the specified record in a specified table with given data.
     *
     * This method takes the data from $data array (second parameter). If this parameter
     * not specified data taken from a POST array.
     *
     * @param   mixed   $id
     * @param   string  $table_name
     * @param   array   $data
     * @return  int
     */
    function saveItem( $id, $table_name, $data = false )
    {
        $CRUD =& $this->getClassOf("db.mysql.CRUD");
        return $CRUD->saveItem( $id, $table_name, $data );
    }

    function moveItemUp( $id, $table_name, $limit_field = "" )
    {
        $CRUD =& $this->getClassOf("db.mysql.CRUD");
        return $CRUD->moveItemUp( $id, $table_name, $limit_field );
    }

    function moveItemDown( $id, $table_name, $limit_field = "" )
    {
        $CRUD =& $this->getClassOf("db.mysql.CRUD");
        return $CRUD->moveItemDown( $id, $table_name, $limit_field );
    }

    function getNextPosition( $table_name, $condition = "" )
    {
        $CRUD =& $this->getClassOf("db.mysql.CRUD");
        return $CRUD->getNextPosition( $table_name, $condition );
    }

/****************************************************************************
 *                          Admin options                                   *
 ****************************************************************************/

    function getAdminEmail()
    {
        return $this->getOption("Settings", "adminEmail");
    }

    function setAdminEmail( $email )
    {
        $this->setOption("Settings", "adminEmail", $email);
    }

} // End Class

?>