<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController
{
    var $contentFile        = "admin/exch_rates/index.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        $mode = $this->getParam("GET", "mode", "string");

        if ( $mode == "save_rate" )
        {
            $cash = 0 + str_replace(",", ".", $this->getParam("POST", "rate_cash", "string"));
            $bank = 0 + str_replace(",", ".", $this->getParam("POST", "rate_bank", "string"));
            $this->setOption("Settings", "phone_pre", $this->getParam("POST", "phone_pre", "string"));
            $this->setOption("Settings", "phone_number", $this->getParam("POST", "phone_number", "string"));
            
            $this->setOption("Rates", "CASH", $cash);
            $this->setOption("Rates", "BANK", $bank);
            $this->redirect( "index.php" , "msg=rate_saved" );
        }


        if (!$mode) {
            $this->tpl->assign( "cash", $this->getOption("Rates", "CASH"));
            $this->tpl->assign( "bank", $this->getOption("Rates", "BANK"));
            $this->tpl->assign( "phone_pre", $this->getOption("Settings", "phone_pre"));
            $this->tpl->assign( "phone_number", $this->getOption("Settings", "phone_number"));
        }


        $msg = $this->getParam("GET", "msg", "string");

        if ( $msg == "rate_saved" )
            $this->showMessage( "Курс сохранен" );

    }

    function render()
    {
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>