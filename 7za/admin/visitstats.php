<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController 
{
    var $contentFile    = "admin/visitstats/pages.tpl.html";
    var $webalizer_url  = "/webalizer/";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        $VS = $this->getClassOf("VisitStats");

        $month  = $this->getParam($_REQUEST, "month", "string");
        $mode   = $this->getParam($_REQUEST, "mode", "string");
        
        if ( !$month )
            $month = date("Y-m");
        
        if ( $mode == "search_phrases" )
        {
            $this->contentFile = "admin/visitstats/phrases.tpl.html";
            $this->tpl->assign("phrases", $VS->getPhrasesStats($month));
            $this->tpl->assign("searchers", $VS->searchers);
            $this->tpl->assign("months", $VS->getAvailableMonthsForPhrases());
        }
        
        if ( $mode == "days" )
        {
            $this->contentFile = "admin/visitstats/days.tpl.html";
            $img_name = "daily_usage_" . str_replace("-", "", $month) . ".png";
            $this->tpl->assign("days_image", $this->webalizer_url . $img_name);
            $months = array(
                0 => array("month" => date("Y-m")),
                1 => array("month" => date("Y-m", strtotime("-1 month"))), 
                2 => array("month" => date("Y-m", strtotime("-2 months"))));
            $this->tpl->assign("months", $months);
        }
        
        if ( $mode == "auditory" )
        {
            $this->contentFile = "admin/visitstats/auditory.tpl.html";
            $img_name = "ctry_usage_" . str_replace("-", "", $month) . ".png";
            $this->tpl->assign("auditory_image", $this->webalizer_url . $img_name);
            $months = array(
                0 => array("month" => date("Y-m")),
                1 => array("month" => date("Y-m", strtotime("-1 month"))), 
                2 => array("month" => date("Y-m", strtotime("-2 months"))));
            $this->tpl->assign("months", $months);
        }
        
        if ( !$mode )
        {
            $this->tpl->assign("pages", $VS->getPageStats($month, "visitstats.php"));
            $this->tpl->assign("months", $VS->getAvailableMonthsForPages());
            $this->tpl->assign("splitMenu", $VS->sm->makeLinkMenu());
        }
    }
    
    function render()
    {
        $this->tplToDisplay = "admin/main.tpl.html";
        $this->tpl->assign("contentFile", $this->contentFile);
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>
