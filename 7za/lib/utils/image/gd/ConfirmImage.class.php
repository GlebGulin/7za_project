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
 * $Cryptor = $this->getClassOf("utils.crypt.MicaCrypt");
 * $key = date("Y-m-d");
 * $code = chr(rand(ord("A"), ord("A")+4)) .rand(10000, 99999);
 * $hash = $Cryptor->encrypt($code, $key);
 * $this->tpl->assign("check_image_hash", $hash);
 *
 * <!-- then in HTML template -->
 * <img src="check_image.php?hash={$check_image_hash}" border="0" align="absmiddle">
 * Enter the text from an image: <input type="text" name="check_image" maxlength="20" class="input">
 * <input type="hidden" name="check_image_hash" value="{$check_image_hash}">
 *
 * // and then a controller for the image
 * $Cryptor = $this->getClassOf("utils.crypt.MicaCrypt");
 * $key = date("Y-m-d");
 * $img_text = $Cryptor->decrypt( $this->getParam("GET", "hash", "string"), $key );
 *          
 * $this->setDontCacheHeaders();
 * $CI = $this->getClassOf("utils.image.gd.ConfirmImage");
 * $CI->outputImage($img_text);
 *
 * // and at last the checking itself after form submitting
 * $this->importIntoClass("POST");
 * $Cryptor = $this->getClassOf("utils.crypt.MicaCrypt");
 * $key = date("Y-m-d");
 * $img_text = $Cryptor->decrypt( $this->check_image_hash, $key );
 * if ( $img_text != $this->check_image )
 * {
 *     $this->errorMessage = "Enter the text from image properly";
 *     return false;
 * }
 * </code>
 *
 * @author Alex Koshel <alex@belisar.de>
 * @version 0.5 (25.10.2005)
 * @package utils
 */
class ConfirmImage extends wrapper
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
  
/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/   
  
    /**
     * constructor
     */
    function ConfirmImage()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/ 	
    
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