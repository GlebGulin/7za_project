<?PHP

// Including Master Controller class
require_once( "MasterController.class.php" );

/**
 * Parent class for all controllers within one area of the site.
 *
 * This class is a part of SmartMVC framework. Every controller
 * class must extend it.
 *
 * @package SmartMVC
 * @version 1.00 (01/09/2004)
 * @author Alex Koshel <alex@fairpoint.com.ua>
 */

class PublicBaseController extends MasterController
{
    var $months     = array( "01" => "Январь",
                             "02" => "Февраль",
                             "03" => "Март",
                             "04" => "Апрель",
                             "05" => "Май",
                             "06" => "Июнь",
                             "07" => "Июль",
                             "08" => "Август",
                             "09" => "Сентябрь",
                             "10" => "Октябрь",
                             "11" => "Ноябрь",
                             "12" => "Декабрь"
                            );

    var $rssURL     = "rss/popular/";

    /**
     * SnimiSlivki number.
     *
     * @var int
     */
    var $ssnumber   = 0;

/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

/****************************************************************************
 *                      Initialization                                       *
 ****************************************************************************/

    /**
     * Constructor for the class.
     *
     * @return  AreaBaseController
     */
    function PublicBaseController()
    {
        parent::MasterController();
    }

    /**
     * Initialization method for all controllers within one area.
     *
     * This method invoked automatically in every controller. So it is intended
     * for common area actions (like session initialization, user authorization
     * checking etc.). But it may be overriden in inherited controller with
     * processing necessary init routines.
     *
     * @return  void
     */
    function init()
    {
        //$this->redirect("/admin/");
//        if ( !is_integer(strpos(@$_SERVER['HTTP_HOST'], 'www.')) && ($_SERVER['HTTP_HOST'] != 'devel.7za.com.ua') && ($_SERVER['HTTP_HOST'] != 'www2.7za.com.ua') && ($_SERVER['HTTP_HOST'] != 'test.7za.com.ua') )
//        {
//            header("HTTP/1.1 301 Moved Permanently");
//            header("Location: http://www.7za.com.ua" . @$_SERVER['REQUEST_URI']);
//            exit();
//        }

        parent::init();
        $this->tplToDisplay = "main.tpl.html";
        $this->leftMenuTpl = "left_menu/main_menu.tpl.html";

        if ( !defined("DONT_DB_CONNECT") )
        {
            $Products = $this->getClassOf("Products");
     	    $sales = $Products->getSales();
     	    if ( $sales )
     	    {
                $item = $sales[rand(0, count($sales)-1)];
                $this->tpl->assign("sale_product", $item);
     	    }
     	    $News = $this->getClassOf('News');
    	    $this->tpl->assign('front_news', $News->getNewsForStartPage());
     	    $Articles = $this->getClassOf('Articles');
    	    $this->tpl->assign('front_articles', $Articles->getLastArticles());

            $Cart     = $this->getClassOf("Cart");
            $this->tpl->assign("cart_not_empty", count($Cart->getCart())?1:0);
            $this->tpl->assign('cart_count', $Cart->getNumProducts());
            $this->tpl->assign('cart_total', $Cart->getCartTotal());
            $this->tpl->assign("rate_cash", $this->getOption("Rates", "CASH"));
            $this->tpl->assign("rate_bank", $this->getOption("Rates", "BANK"));
            $this->tpl->assign("phone_pre", $this->getOption("Settings", "phone_pre"));
            $this->tpl->assign("phone_number", $this->getOption("Settings", "phone_number"));
            
        }
    }

    function display()
    {
        $this->tpl->assign("rssURL", $this->rssURL);
        parent::display();
    }

} // End Class

?>