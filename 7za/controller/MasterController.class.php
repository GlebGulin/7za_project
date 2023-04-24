<?PHP
// Including global configuration
require_once( str_replace( "controller", "lib", realpath( dirname( __FILE__ ) ) ) . "/config.inc.php" );

/**
 * This is the base class of <b>each</b> controller. If you search for a place,
 * where you can put controller methods, which gets used by the entire
 * application; This is the right place!
 *
 *
 * @package SmartMVC
 * @version 1.00 (30/05/2005)
 * @author Ralf Kramer <kramer@ebimos.de>
 */

class MasterController extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    /**
     * Contains the name of a template to be shown by default.
     *
     * @var     string
     */
    var $tplToDisplay       = "";
    var $stageTpl           = "";
    var $contentFile        = "";
    var $pageTitle          = "";
    var $pageKeywords       = "";
    var $pageDescription    = "";
    var $language           = "rus";
    var $month_names        = array( "01" => "€нвар€",
                                     "02" => "феврал€",
                                     "03" => "марта",
                                     "04" => "апрел€",
                                     "05" => "ма€",
                                     "06" => "июн€",
                                     "07" => "июл€",
                                     "08" => "августа",
                                     "09" => "сент€бр€",
                                     "10" => "окт€бр€",
                                     "11" => "но€бр€",
                                     "12" => "декабр€"
                                    );

    /**
    * Whether to encode request arrays to prevent XSS attack.
    *
    * @var  boolean
    */
    var $encodeRequestArrays    = true;

    /**
     * The application name.
     *
     * @var string
     */
    var $applicationName    = "7Za";

/****************************************************************************
 *                      Initialization                                       *
 ****************************************************************************/

    /**
     * Constructor for the class.
     *
     * @return  MasterController
     */
    function MasterController()
    {
        parent::wrapper();
    }

    /**
     * Initialization method for all controllers on your site.
     *
     * This method invoked automatically in every controller. So it is intended
     * for wide-site actions (like some global variables assigning etc.).
     * But it may be overriden in inherited controllers with
     * processing necessary init routines.
     *
     * @return  void
     */
    function init()
    {
        session_start("publicArea");
    }

    /**
     * Main method for the controller.
     *
     * This method executed automatically and should contain all workflow control
     * of the page.
     * Leave this method empty here and override it in inherited classes.
     *
     * @return  void
     */
    function process()
    {
    }

    /**
     * Put here site wide template and language preparations.
     *
     * @return  void
     * @access  public
     * @author  Ralf Kramer <rk@belisar.de>
     */
    function display( )
    {
        $this->tpl->assign( "stageTpl", $this->stageTpl );
        $this->tpl->assign( "contentFile", $this->contentFile );
        $this->tpl->assign( "pageTitle", $this->pageTitle );
        $this->tpl->assign( "pageKeywords", $this->pageKeywords );
        $this->tpl->assign( "pageDescription", $this->pageDescription );
        $this->tpl->assign( "language", $this->language );
        $this->tpl->assign( "monthNames", $this->month_names );
        wrapper::display();
    }

    /**
     * Finalization method for all controllers.
     *
     * @return  void
     */
    function finalize()
    {
    }

    /**
     * This method used for outputting the message on the page.
     *
     * @return   void
     * @param    string     $msg
     * @access   public
     */
    function showMessage( $msg )
    {
        $this->tpl->assign( "page_msg", $msg );
    }


} // End Class

?>