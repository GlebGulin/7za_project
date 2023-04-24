<?php
		$this->moduleTpl = "CMS/contacts/index.tpl.html";

        $mode = $this->getParam("POST", "mode", "string");

        $Contacts = $this->getClassOf("Contacts");
        $Captcha = $this->getClassOf("utils.image.gd.Captcha");

        //$this->tpl->assign( "contacts" , $Contacts->getContactsForFrontend( $this->language ) );

        if ( $mode == "send" )
        {
            $Contacts->importIntoClass("POST");
            $captcha_code = $this->getParam("POST", "captcha_code", "string");

            if ( !$Contacts->checkContactForm() )
            {
                $this->passToTemplate($_POST);
                $this->showMessage("Заполните форму, пожалуйста");
            }
            elseif ( !$captcha_code || !$Captcha->checkCaptcha($captcha_code) )
            {
                $this->passToTemplate($_POST);
                $this->showMessage("Введите код с картинки");
            }
            else
            {
                $Contacts->importIntoClass($_POST);
                $Contacts->sendMail();
                $this->redirect( "/pages/8/" , "msg=sent");
            }
        }

        $Captcha->initCaptcha();

        $msg = $this->getParam("GET", "msg", "string");

        if ( $msg == "sent" )
            $this->showMessage("Ваше письмо успешно отправлено администратору");

        //$this->parseLanguagePage("contacts");

?>