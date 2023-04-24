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
 * Parent class for all entity-oriented classes of SmartMVC.
 *
 * This class is a part of SmartMVC framework. Every entity-oriented
 * class must extend it and all it's properties.
 *
 * @package SmartMVC
 * @version 1.00 (25/06/2004)
 * @author Ralf Kramer <rk@belisar.de>
 * @author Alex Koshel <alex@belisar.de>
 */

class main extends dbHandler
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
    var $rb                 = array();

    /**
    * Array with language messages.
    *
    * @var  array
    */
    var $lang               = array();
    /**
    * SplitMenu holder.
    *
    * Use function $this->initSplitMenu() for splitMenu initialization. After this call
    * $this->sm variable will contain SplitMenu instance.
    *
    * @var  class
    */
    var $sm                 = "";
    /**
    * Used for splitMenu tool.
    *
    * @ignore
    */
    var $smIndex            = "";
    /**
    * Used for splitMenu tool.
    *
    * @ignore
    */
    var $smLimitClause      = "";

    /**
    * Array with forbidden membervar names.
    *
    * This array used during importing vars into the class to avoid
    * overwriting values to SmartMVC core variables.
    *
    * @var  array
    * @see  importIntoClass()
    * @see  addCoreVars()
    */
    var $coreVars           = array();

    /**
    * Array with class handlers for implementing Singleton pattern.
    *
    * @var  array
    * @see  getClassOf()
    */
    var $classes            = array();

    /**
    * Template engine handle.
    *
    * @var  class
    */
    var $tpl                = "";
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
    * Specified whether current controller must insert URL hashes to output.
    *
    * Override this variable in your controller classes with default value
    * of <i>true</i> to explore final output and insert hashes.
    *
    * @see  makeURLHashes()
    * @var  boolean
    */
    var $makeURLHashes      = false;
    /**
    * Core application name.
    *
    * @var  string
    */
    var $applicationName    = "";

/****************************************************************************
 *                      Initialization                                       *
 ****************************************************************************/

    /**
     * Construtor for the class.
     *
     * @author  Alex Koshel
     * @return  main
     */
    function main()
    {
        $this->loadResourceBundle();
        if ( !defined("DONT_DB_CONNECT") )
        {
            $this->dbConnect();
            dbHandler::runQuery( "SET NAMES cp1251", "none", "DB init" );
        }

        $this->addCoreVars(array_keys(get_class_vars("main")));
        // removing smIndex from core vars
        if (in_array("smIndex", $this->coreVars))
            unset($this->coreVars[array_search("smIndex", $this->coreVars)]);

        // setting the value of SmartSplitMenu index
        if (isset($_GET["smIndex"]) && is_numeric($_GET["smIndex"]))
            $this->smIndex = $_GET["smIndex"];

        // mounting Request class
        $this->request = $this->getClassOf("vars.Request");

       /**
        * We use the Smarty template engine.
        *
        * It is highly recommended to use only the global
        * variables if an absolute url is needed
        */
        $this->tpl = $this->getClassOf("view.smartyMVC");
        $this->tpl->addGlobalVar( "URL_STYLE", URL_STYLE );
        $this->tpl->addGlobalVar( "URL_IMAGE", URL_IMAGE );
        $this->tpl->addGlobalVar( "URL_SCRIPT", URL_SCRIPT );
        $this->tpl->addGlobalVar( "URL_ROOT", URL_ROOT );

       /**
        * Example code for using another template engine
        *
        $this->tpl = $this->getClassOf("view.patTemplate"); // new patTemplate();
        $this->tpl->setBaseDir( TEMPLATE_DIR );
        */

        // Checking for URL hashes corresponding
        if ($this->checkURLHash)
        {
            if (isset($_GET["url_hash"]))
            {
                $hash = $_GET["url_hash"];
                $request = '?'.substr($_SERVER['QUERY_STRING'], 0, strpos($_SERVER['QUERY_STRING'], 'url_hash'));
                $cryptor = $this->getClassOf("utils.crypt.MicaCrypt");
                $got_request = $cryptor->decrypt($hash, URL_HASH_KEY);
                if ($request == $got_request) return true;
            }
            $this->redirect(ERROR_PAGE);
        }
    }

/****************************************************************************
 *                      Dispatcher method                                   *
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
        $classFName = str_replace('.', '/', $fullClassName).'.class.php';
        if ( is_integer( strpos( $fullClassName, '.' ) ) )
            $className = substr( $fullClassName, strrpos($fullClassName, '.')+1 );
        else $className = $fullClassName;

        // make it a singleton method
        if( class_exists( $className ) && isset($this->classes[$className]) && is_object($this->classes[$className]) )
        {
            if ($import)
            {
                // importing an array to the class
                if (method_exists($this->classes[$className], "importIntoClass"))
                    $this->classes[$className]->importIntoClass($import);
                else
                    $this->addDebugMsg("The invoked class is not model class", "DispatcherError");
            }
            return $this->classes[$className];
        }


        // Searching in library
        if (is_file( LIB . $classFName )) {

            require_once( LIB . $classFName );
            $this->classes[$className] = new $className();
        }
        // Searching within model folder
        elseif (is_file( MODEL_DIR . $classFName )) {
            require_once( MODEL_DIR . $classFName );
            $this->classes[$className] = new $className();
        }

        if ( isset($this->classes[$className]) && is_object($this->classes[$className]) )
        {
            if ($import)
            {
                if (method_exists($this->classes[$className], "importIntoClass"))
                    $this->classes[$className]->importIntoClass( $import );
                else
                    $this->addDebugMsg("The invoked class is not model class", "DispatcherError");
            }

            return $this->classes[$className];
        }

        // If the class not found
        $this->addDebugMsg( "Cannot find " . $fullClassName . " class", "DispatcherError" );
        return false;
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
    function modelFactory( $class_name, $method_name, $params = array() )
    {
        $class =& $this->getClassOf( $class_name );

        if( empty( $params ) )
            return $class->$method_name();

        if( count( $params ) == 1 )
            return $class->$method_name( $params[0] );

        if( count( $params ) == 2 )
            return $class->$method_name( $params[0], $params[1] );

        if( count( $params ) == 3 )
            return $class->$method_name( $params[0], $params[1], $params[2] );

        if( count( $params ) == 4 )
            return $class->$method_name( $params[0], $params[1], $params[2], $params[3] );

        if( count( $params ) == 5 )
            return $class->$method_name( $params[0], $params[1], $params[2], $params[3], $params[4] );

        if( count( $params ) > 5 )
            $this->addDebugMsg( 'this method is allows only 5 params', __FILE__."".__LINE__ );
    }

/****************************************************************************
 *                      Importing variables to the class                    *
 ****************************************************************************/

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
                    if (!$this->existCoreVar($key)) $this->$key = $value;
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

/****************************************************************************
 *                      Language files parsing                              *
 ****************************************************************************/

    /**
     * Loads the language file into the class.
     *
     * @author  Alex Koshel
     * @return  void
     * @param   string  $langFile   The name of language file
     */
    function loadLanguageFile( $langfile )
    {
        if ( file_exists( LANG_DIR . $langfile ) )
        {
            $this->lang = parse_ini_file( LANG_DIR . $langfile, true );
        }
    }

/****************************************************************************
 *                      loadResourceBundle                                  *
 ****************************************************************************/

    /**
     * Loads the conf file and applies it's contents to $this->rb.
     *
     * This method invoked within the constructor of main class.
     *
     * @author  Ralf Kramer
     * @author  Alex Koshel
     * @return  true
     */
    function loadResourceBundle()
    {
        if( !file_exists( PATH_TO_RESOURCE_BUNDLE ) || !is_file( PATH_TO_RESOURCE_BUNDLE ) )
            return false;

        if ($this->rb = parse_ini_file( PATH_TO_RESOURCE_BUNDLE, true )) return true;
        else
        {
            $this->addDebugMsg("Cannot load resource bundle.", PATH_TO_RESOURCE_BUNDLE );
            return false;
        }
    }

/****************************************************************************
 *                      utilities                                           *
 ****************************************************************************/

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
    function initSplitMenu( $target_url, $index_length, $data_elements, $params = "" )
    {
        $this->sm = $this->getClassOf( 'utils.splitMenu.SmartSplitMenu');
        $this->sm->setTargetUrl( $target_url );
        $this->sm->setIndex( $this->smIndex );
        $this->sm->setDataElements( $data_elements );
        $this->sm->setIndexLength( $index_length );
        $this->sm->setAvailableSites();
        $this->sm->setAdditionalParams( $params );
        $this->smLimitClause = $this->sm->getLimitClause();
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
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Cache-Control: post-check=0,pre-check=0");
        header("Cache-Control: max-age=0");
        header("Pragma: no-cache");
    }

    /**
     * Returns the reference table ready for passing to template.
     *
     * @return array
     * @param   string  $table          table name
     * @param   string  $key_field      the name of a key field
     * @param   string  $value_field    the name of a value field
     * @param   string  $order_field    the name of a field on which sorting performed
     * @access public
     * @author Alex Koshel <alex@belisar.de>
     */
    function getReferenceTable( $table, $key_field = "id", $value_field = "value", $order_field = "" )
    {
        if (empty($order_field))
            $order_field = $key_field;

        $sql_q = "SELECT * FROM " . $table . " ORDER BY " . $order_field;
        $res = array();
        $records = dbHandler::runQuery($sql_q, "getIndexArray", __FILE__ . ':' . __LINE__ );
        if (is_array($records))
            foreach ($records as $record)
                $res[$record[$key_field]] = @$record[$value_field];

        return $res;
    }

/****************************************************************************
 *                     Development stage methods                            *
 ****************************************************************************/

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
        require_once(LIB . "debug/debugFunctions.inc.php");
        return displayRecords($data);
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
        require_once(LIB . "debug/debugFunctions.inc.php");
        return displayArray($data);
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
        require_once(LIB . "debug/debugFunctions.inc.php");
        return queryProposal($table, $operation);
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
    function getFileType( $file )
    {
        $file_name = basename( $file );
        // if there is no file extension - return false
        if (!is_integer(strpos($file_name, '.'))) return false;
        $elements  = explode( ".", $file_name );
        return $elements[count($elements)-1];
    }

/****************************************************************************
 *                      Language files parsing                              *
 ****************************************************************************/

    /**
     * Parses section of language file and passes it to template engine.
     *
     * Also the name of a section from language file may be specified as the param.
     *
     * @author  Alex Koshel
     * @return  void
     * @param   array   $values The associative array or section name
     */
    function parseLanguagePage( $values )
    {
        if (is_array($values))
        {
            $this->passToTemplate($values);

            if ( isset($this->lang["charset"]["CHARSET"]) )
                $this->tpl->addGlobalVar("CHARSET", $this->lang["charset"]["CHARSET"]);
        }
        else
        {
            if (isset($this->lang[$values]))
                $this->parseLanguagePage($this->lang[$values]);
            else
                $this->addDebugMsg("There is no such language page", "parseLanguageFile() error");
        }
    }

    /**
    * Passes specified associative array to the template engine.
    *
    * @return void
    * @param    array   $values     associative array to be passed to TE
    */
    function passToTemplate( $values )
    {
        foreach ($values as $key=>$value)
            $this->tpl->addGlobalVar($key, $value);
    }

/****************************************************************************
 *                      Form generation function                            *
 ****************************************************************************/

    function generateForm( $xml_file, $smarty_code = true )
    {
        $frmGenerator = $this->getClassOf("utils.forms.FormGenerator");

        print '<pre>' . htmlspecialchars($frmGenerator->generateHTMLForm($xml_file, $smarty_code), ENT_QUOTES, 'cp1251') . '</pre>';
        //$this->tpl->frmGenerator = $this->getClassOf("utils.forms.FormGenerator");
        //$this->tpl->frmGenerator->readXMLTemplate($xml_file);
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
        $frmGenerator = $this->getClassOf("utils.forms.FormGenerator");

        $this->tpl->assign("js_validation", $frmGenerator->getValidationCode($xml_file, $error_msg));
    }

/****************************************************************************
 *                      SimpleCounter class wrapper                         *
 ****************************************************************************/

    function countHitForArea( $area )
    {
        $this->modelFactory("utils.counters.SimpleCounter", "countHit", array(0 => $area));
    }

    function getCounterStatsPage()
    {
        return $this->modelFactory("utils.counters.SimpleCounter", "getStatsPage");
    }

    function getCounterStats()
    {
        return $this->modelFactory("utils.counters.SimpleCounter", "getStats");
    }

/****************************************************************************
 *                    XSS attack preventing                                 *
 ****************************************************************************/

    /**
     * Encoding all request arrays for preventing XSS attack.
     *
     * @return   void
     * @param    string     $filter     the name of a filter
     * @access   public
     */
    function preventXssAttack( $filter = "common" )
    {
        // prevent repeated encoding
        if ( isset( $this->encodedRequestXSS ) )
            return false;
        else
            $this->encodedRequestXSS = true;

        // processing POST array
        foreach ( $_POST as $key => $value )
            if ( !is_array($value) )
                $_POST[ $key ] = $this->processRequestValue( $value, $filter );
            else
                foreach ( $value as $key2 => $value2 )
                    $_POST[ $key ][ $key2 ] = $this->processRequestValue( $value2, $filter );

        // processing GET array
        foreach ( $_GET as $key => $value )
            if ( !is_array($value) )
                $_GET[ $key ] = $this->processRequestValue( $value, $filter );
            else
                foreach ( $value as $key2 => $value2 )
                    $_GET[ $key ][ $key2 ] = $this->processRequestValue( $value2, $filter );

        // processing REQUEST array
        foreach ( $_REQUEST as $key => $value )
            if ( !is_array($value) )
                $_REQUEST[ $key ] = $this->processRequestValue( $value, $filter );
            else
                foreach ( $value as $key2 => $value2 )
                    $_REQUEST[ $key ][ $key2 ] = $this->processRequestValue( $value2, $filter );
    }

    /**
     * Replaces in a text most malicious chars to their HTML equivalent.
     *
     * @return   string
     * @param    string     $value
     * @param    string     $filter     the name of a filter
     * @access   private
     */
    function processRequestValue( $value, $filter = "common" )
    {
        if ( get_magic_quotes_gpc() )
            $value = stripslashes( $value );

        if ( $filter == "common" )
        {
            $value = str_replace( '&', "&#38;", $value );
            $value = str_replace( '<', "&lt;", $value );
            $value = str_replace( '>', "&gt;", $value );
            $value = str_replace( '(', "&#40;", $value );
            $value = str_replace( ')', "&#41;", $value );
            $value = str_replace( '"', "&quot;", $value );
            $value = str_replace( "'", "&#146;", $value );
            $value = str_replace( "`", "&#96;",    $value );
        }

        if ( $filter == "textEmail" )
        {
            $value = preg_replace("/<script.*>.*<\/script>/i", "", $value);
        }

        return $value;
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
        $value = str_replace( "&#96;", '`', $value );
        $value = str_replace( "&#146;", "'", $value );
        $value = str_replace( "&quot;", '"', $value );
        $value = str_replace( "&#41;", ")", $value );
        $value = str_replace( "&#40;", "(", $value );
        $value = str_replace( "&lt;", "<", $value );
        $value = str_replace( "&gt;", ">", $value );
        $value = str_replace( "&#38;", "&", $value );

        return $value;
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
    function makeURLHashes( $output )
    {
        $crypter = $this->getClassOf("utils.crypt.MicaCrypt");
        $pattern = "/([\w\d\-_]+\.[\w\d\-]{1,4})(\?([\w\d\-_]+\=[^&]*&)+)url_hash/ie";
        //return preg_replace($pattern, "'\\1\\2'.'url_hash='.substr(\$crypter->encrypt('\\2', URL_HASH_KEY),0,20)", $output);
        return preg_replace($pattern, "'\\1\\2'.'url_hash='.\$crypter->encrypt('\\2', URL_HASH_KEY)", $output);
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
        print $this->makeURLHashes( $this->tpl->fetch($tpl) );
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
    function display()
    {
        // Displaying the template
        if (!empty( $this->tplToDisplay ))
        {
            if ($this->makeURLHashes)
            {
                $this->makeHashesAndDisplay( $this->tplToDisplay );
            }
            else
            {
                $this->tpl->display( $this->tplToDisplay );
            }
        }
        else return false;
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
        $this->stp = $this->getClassOf("utils.dates.SmartTimePeriod");
        $this->stp->setInitValues($startDate, $endDate);
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
        $res_array = explode( $delimiter, $string );
        array_pop( $res_array );
        $res_array = array_reverse( $res_array );
        array_pop( $res_array );
        return $res_array;
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
        $res_string = $delimter;
        foreach ($data_array as $value )
        {
            $res_string .= $value . $delimter;
        }
        return $res_string;
    }

    /**
     * Fills any value with leading zeros.
     *
     * @author  Ralf Kramer
     * @param   string  $val
     * @param   integer $length max lenght of return value
     * @return  string
     */
    function zerofill( $val, $length )
    {
        while( strlen( $val ) < $length )
            $val = "0" . $val;

        return $val;
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
        $isValidVar = $this->request->validateRequest( $request_tpye,
                    array( array("name" => $var_name, "type" => $var_type) ) );

        if( $isValidVar )
            return true;
        else
            return false;
    }

} // End Class

?>
