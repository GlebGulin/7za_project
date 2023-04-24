<?PHP
/**
 * The class for outputting the image for confirming manual data entering.
 *
 * This class is useful in registration forms or other kind of forms where
 * avoiding possibility of automatic data entering required.
 * It outputs an image with specified text and some "noise", it generates
 * different image each time, so it proves on 100% that data entered on a form
 * filled by human.
 *
 * Example of use (within SmartMVC framework):
 * <code>
 * // in a controller
 * $Captcha = $this->getClassOf("utils.image.gd.Captcha");
 * $Captcha->initCaptcha();
 *
 * <!-- then in HTML template -->
 * {$captcha_image}
 * Enter the text from an image: <input type="text" name="captcha_code" maxlength="20" class="input">
 *
 * // and at last the checking captcha code after form submitting
 * $this->getClassOf("utils.image.gd.Captcha");
 * $code = $this->getParam("POST", "captcha_code", "string");
 * if ( !$Captcha->checkCaptcha($code) )
 * {
 *     $this->errorMessage = "Enter the text from image properly";
 *     return false;
 * }
 * </code>
 *
 * @author Alex Koshel <alex@fairpoint.com.ua>
 * @version 1.0 (16.09.2007)
 * @package utils
 */
class Captcha extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/
    /**
     * Used for keeping outputting text.
     *
     * @var     string
     */
    var $image_text         = "";

    /**
     * The width of an image, in pixels.
     *
     * @var     int
     */
    var $imageWidth         = 90;

    /**
     * The height of an image, in pixels.
     *
     * @var     int
     */
    var $imageHeight        = 35;

    /**
     * Specifies whether to draw border.
     *
     * @var     boolean
     */
    var $drawBorder         = true;

    /**
     * The quantity of pixels for the "noise".
     *
     * @var     int
     */
    var $numPixels          = 80;

    var $img_html = '<img src="/Modules/Captcha/captcha.php" border="0" align="absmiddle" alt="" />';

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     */
    function Captcha()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

    /**
     * Should be called before captcha displaying.
     *
     */
    function initCaptcha()
    {
        $code = '' . rand(100000, 999999);
        $_SESSION["captcha_code"] = $code;

        global $core;
        $core->tpl->assign("captcha_image", $this->img_html);
    }

    function checkCaptcha( $code )
    {
        if ( empty($code) )
            return false;

        if ( !isset($_SESSION["captcha_code"]) || empty($_SESSION["captcha_code"]) )
            return false;

        $img_text = @$_SESSION["captcha_code"];
        if ( $img_text != $code )
            return false;
        else
            return true;
    }

    /**
     * Sould be called everytime after proper image submitting.
     *
     */
    function killCaptcha()
    {
        if ( isset($_SESSION["captcha_code"]) )
            unset($_SESSION["captcha_code"]);
    }

    /**
     * Outputs an image with specified text.
     *
     * @return   void
     * @param    string     $image_text     the text for displaying on the image
     * @access   public
     */
    function outputImage( $image_text )
    {
        $img = @imagecreatetruecolor($this->imageWidth, $this->imageHeight);
        $white = imagecolorallocate($img, 255, 255, 255);
        imagefill($img, 0, 0, $white);
        $black = imagecolorallocate($img, 0, 0, 0);

        // draw border
        if ( $this->drawBorder )
            imagerectangle($img, 0, 0, $this->imageWidth-1, $this->imageHeight-1, $black);

        $gray = imagecolorallocate($img, 128, 128, 128);
        $text_y = round($this->imageHeight / 2) - 8;

        // outputting text
        for ( $i = 0; $i < strlen($image_text); $i++ )
        {
            $r = rand(0, 4) - 2;
            imagestring($img, 5, 15 + $i*10, $text_y+$r, $image_text{$i}, $gray);
        }

        // putting pixels
        for ( $i = 0; $i < $this->numPixels; $i++ )
        {
            $x = rand(0, $this->imageWidth-1);
            $y = rand(0, $this->imageHeight-1);
            imagesetpixel($img, $x, $y, $gray);
        }

        header('Connection: close');
        header('Content-Type: image/jpeg');
        header('Content-Disposition: inline; filename=file.jpg');
        imagejpeg($img);
    }

}
?>