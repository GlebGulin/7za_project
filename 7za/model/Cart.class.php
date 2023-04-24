<?PHP

require_once( MODEL_DIR . "Products.class.php" );

class Cart extends Products
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $subject           = "Онлайн-заказ с сайта '7za'";
    var $email			   = "";
    var $name              = "";
    var $surname           = "";
    var $phone             = "";
    var $comment           = "";

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function Cart()
    {
       parent::wrapper();
    }


/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

	/**
	 * Get cart from session
	 *
	 * @return array
	 */
    function getCart()
    {
    	global $_SESSION;
if ((isset($_SESSION['shopping_cart'])) and (is_array($_SESSION['shopping_cart']))) {
	foreach ($_SESSION['shopping_cart'] as $cart_item_id => $cart_item) {
		if (!is_array($cart_item) and (is_numeric($cart_item))) unset($_SESSION['shopping_cart'][$cart_item_id]);
	}
}
    	return isset($_SESSION['shopping_cart']) ? $_SESSION['shopping_cart'] : array();
    }

    /**
     * Save cart in session
     *
     * @param array $cart
     */
    function setCart($cart)
    {
    	global $_SESSION;
    	$_SESSION['shopping_cart'] = $cart;
    }

    /**
     * Returns the quantity of products in a cart.
     *
     * @return int
     */
    function getNumProducts()
    {
        $cart = $this->getCart();
        $num = 0;
        foreach ($cart as $product_id => $product )
            $num += $product["quantity"];

        return $num;
    }

	/**
	 * Add item to cart
	 *
	 * @param int $product_id
	 * @param int $quantity
	 */
    function addToCart( $product_id, $quantity = 1)
    {
        $cart = $this->getCart();
        if ( isset($cart[$product_id]) )
            $cart[$product_id]["quantity"] += $quantity;
        else
        {
            $product = $this->getProductById($product_id);
            if ( $product && $product["shown"] )
            {
                $cart[$product_id] = $product;
                $cart[$product_id]["quantity"] = $quantity;
            }
        }
        $this->setCart($cart);
    }

    /**
     * Remove item from cart
     *
     * @param int $id
     */
    function deleteFromCart( $id )
    {
        $cart = $this->getCart();
        if ( isset($cart[$id]) )
        {
            unset($cart[$id]);
            $this->setCart($cart);

        }
    }

    /**
     * Return products from cart for page
     *
     * @return unknown
     */
    function getCartForPage()
    {
        $cart = $this->getCart();
        $cart_list = array();

        $i = 0;
        foreach ( $cart as $product_id => $product )
        {
            //$product = $this->getProductById($product_id);
            if ( $product['discount_start'] <= date("Y-m-d") &&
                $product['discount_finish'] >= date("Y-m-d") &&
                $product['discount'] > 0 )
                $product['price'] = $product['price'] - $product['price']*$product['discount']/100;
            $cart_list[$i] = $product;
            //$cart_list[$i]['quantity'] = $qty;
            $i++;
        }
        return $cart_list;
    }

    /**
     * Computes the total price of a cart.
     *
     * @return float
     */
    function getCartTotal()
    {
        $cart = $this->getCart();
        $sum = 0;

        foreach ( $cart as $products_id => $product )
        {
            if ( $product['discount_start'] <= date("Y-m-d") &&
                $product['discount_finish'] >= date("Y-m-d") &&
                $product['discount'] > 0 )
                $product['price'] = $product['price'] - $product['price']*$product['discount']/100;
            $sum += $product['quantity'] * $product['price'];
        }

        return $sum;
    }

    /**
     * Send order to admin
     *
     */
    function sendOrder()
    {
        $cart = $this->getCart();
        $sum = 0;
        $count = 0;
        foreach ( $cart as $product_id => $product )
        {
            //$product = $this->getProductById($product_id);
            $order[$product_id]['price']      = $product['price'];
            $order[$product_id]['name']       = $product['product_name'];
            $order[$product_id]['count']      = $product['quantity'];
            $order[$product_id]['price_summ'] = $product['price'] * $product['quantity'];
            $sum += $order[$product_id]['price_summ'];
            $count += $product['quantity'];
        }

        $this->passToTemplate($_POST);

        $this->tpl->assign('order', $order);
        $this->tpl->assign('order_count', $count);
        $this->tpl->assign('order_summ', $sum);

        $mailer = $GLOBALS['smtp_mail'];
        $headers['From'] = sprintf("\"=?windows-1251?B?%s?=\" <%s>", base64_encode('Интернет магазин 7ZA'), FROM_EMAIL);
        $headers['MIME-Version'] = '1.0';
        $headers['Content-Type'] = 'text/html; charset="windows-1251"';
        $headers['Content-Transfer-Encoding'] = '8bit';
        $recipients = ADMIN_EMAIL;
        $headers['To'] = $recipients;
        if ($this->email) $headers['Reply-To'] = $this->email;
        $headers['Subject'] = $this->subject;
        if (preg_match("/[\x80-\xFF]/", $headers['Subject'])) $headers['Subject'] = sprintf("=?windows-1251?B?%s?=", base64_encode($headers['Subject']));
        $body = $this->tpl->fetch("mails/order.tpl.html");
        $send = $mailer->send($recipients, $headers, $body);

        if (!PEAR::isError($send)) {
            $this->emptyCart();
        }

/*
        $mailer =& $this->getClassOf("utils.mail.MailLauncher");
        $mailer->init( $this->rb["admin"]["email"] , $this->subject, $this->email ? $this->email : "admin@".$_SERVER['HTTP_HOST']);
        $mailer->setCharset("windows-1251");
        $mailer->setBody($this->tpl->fetch("mails/order.tpl.html"));
        $mailer->send();
        $this->emptyCart();
*/

    }

    /**
     * Remove all items from cart
     *
     */
    function emptyCart()
    {
    	$this->setCart(array());
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
    function runQuery( $query_id, $result, $msg_id ) {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        return $this->core->runQuery( $query[$query_id], $result, $msg_id );
    }

}
?>