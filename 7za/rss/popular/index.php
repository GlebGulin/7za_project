<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/PublicBaseController.class.php");

class Controller extends PublicBaseController
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        $Products = $this->getClassOf("Products");

        $weekdays = array(
                            0 => "Sun",
                            1 => "Mon",
                            2 => "Tue",
                            3 => "Wed",
                            4 => "Thu",
                            5 => "Fri",
                            6 => "Sat",
                          );
        $months = array(
                            1 => "Jan",
                            2 => "Feb",
                            3 => "Mar",
                            4 => "Apr",
                            5 => "May",
                            6 => "Jun",
                            7 => "Jul",
                            8 => "Aug",
                            9 => "Sep",
                            10 => "Oct",
                            11 => "Nov",
                            12 => "Dec"
                        );
        $pub_date = $weekdays[date("w")] . date(", d ") . $months[date("n")] . date(" Y H:i:s +0200");
        $this->tpl->assign("pub_date", $pub_date);
    	$this->tpl->assign( "products", $Products->getSaleLeaders() );
    }

    function render()
    {
        // Set template to display
        $this->tplToDisplay = "rss/popular_gifts.tpl.xml";
        $this->display();
    }
}


/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>