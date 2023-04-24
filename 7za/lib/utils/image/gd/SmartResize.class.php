<?php

/**
* Image resizing tool [<i>utils.image.gd.SmartResize</i>].
*
* Utializes GD library to manipulate with images.
*
* Usage example (within SmartMVC framework):
* <code>
* $smartResize = $this->getClassOf("utils.image.gd.SmartResize");
* $smartResize->setMaxSize(150, 100);
*
* $smartResize->processImage("Diver.jpg", true, 'New_Diver');
* </code>
*
* @package		utils
* @access		public	
* @author		Ralf Kramer <rk@belisar.de>
* @author       Alex Koshel <alex@belisar.de>
* @version		1.0
*/
class SmartResize {

    /**
    * Stores filename of processing image.
    *
    * @var     string
    */
    var $imageFilename  = "";
    
    /**
    * Stores type (extension) of processing image.
    *
    * @var     string
    */
    var $imageType      = "";
    
    /**
    * Handler to binary data of image.
    *
    * @var     string
    */
    var $loadedImage    = FALSE;
    
    /**
    * Width of processing image.
    *
    * @var     string
    */
    var $imageSizeW     = FALSE;
    
    /**
    * Height of processing image.
    *
    * @var     string
    */
    var $imageSizeH     = FALSE;
    
    /**
    * Quality for storing JPEGs (0-100).
    *
    * @var     int
    */
    var $jpgQuality     = 90;
    
    /**
    * Maximum width of resized image.
    *
    * @see  setMaxWidth()
    * @see  setMaxSize()
    *
    * @var     int
    */
    var $maxImageW      = 0;
    
    /**
    * Maximum height of resized image.
    *
    * @see  setMaxHeight()
    * @see  setMaxSize()
    *
    * @var     int
    */
    var $maxImageH      = 0;

    /**
    * Constructor.
    *
    * Creates new SmartResize object.
    *
    * @access	public
    * @param	string	$maxWidth	default maximal allowed image width
    * @param	string	$maxHeight	default maximal allowed image height
    * @return   SmartResize
    */
    function SmartResize( $maxWidth = 150, $maxHeight = 50)
    {
        $this->setMaxSize($maxWidth, $maxHeight);
    }
    
    /**
    * Sets JPG quality (needed when saving image).
    *
    * @param   integer     $quality    integer value 0-100
    * @return  void
    * @access  public
    */
    function setJpgQuality($quality) {
        $this->jpgQuality = $quality;
    }

    /**
    * Loads image.
    *
    * Returns image handler parsable by GDlib functions.
    * 
    * @param	string	$image	path to the image
    * @return   boolean
    * @access	public
    */
    function loadImage($image)
    {
        $this->imageFilename = $image;

        if (is_file($this->imageFilename))
        {
            $this->getImageTypeByHeader();
            if ($this->imageType == "jpg" or $this->imageType == "png" or $this->imageType == "gif")
            {
                switch($this->imageType)
                {
                    case "jpg":
                        if ($this->loadedImage = @imageCreateFromJpeg($this->imageFilename))
                        {
                            return true;
                        }
                        break;

                    case "png":
                        if ($this->loadedImage = @imageCreateFromPng($this->imageFilename))
                        {
                            return true;
                        }
                        break;
                        
                    case "gif":
                        if ($this->loadedImage = @imageCreateFromGif($this->imageFilename))
                        {
                            return true;
                        }
                        break;
                }
            }
        }
        return false;
    }

    /**
    * Gets image type by image header.
    * 
    * @access	private
    * @param    string  $fileName
    * @return   string
    */
    function getImageTypeByHeader( $fileName = false )
    {
        if (!$fileName) $fileName = $this->imageFilename;
        
        if ($fileName)
        {
            if ($imageType = getimagesize($fileName))
            {
                if ($imageType[2] == 1)
                    $this->imageType = "gif";
                elseif ($imageType[2] == 2)
                    $this->imageType = "jpg";
                elseif ($imageType[2] == 3)
                    $this->imageType = "png";
                
                return $this->imageType;
            }
        }
        return false;
    }



    /**
    * Gets image type by extension.
    * 
    * @access	private
    * @param    string  $fileName
    * @return   string
    */
    function getImageTypeByExt( $fileName = false )
    {
        if (!$fileName) $fileName = $this->imageFilename;
        
        if ($fileName)
        {
            if ($this->imageType)
                unset($this->imageType);
            
            $this->imageType = substr($fileName, strrpos($fileName, ".")+1);
            if ($this->imageType == "jpeg" or $this->imageType == "")
                $this->imageType = "jpg";
            
            if ($this->imageType)
                return $this->imageType;
        }
        return false;
    }


    /**
    * Gets image width and height.
    * 
    * @access   private
    * @return   boolean
    */
    function getImgSizeWH()
    {
        if ($this->loadedImage)
        {
            if ($this->imageSizeW && $this->imageSizeH)
                unset($this->imageSizeW, $this->imageSizeH);
            
            $this->imageSizeW = @imagesx($this->loadedImage);
            $this->imageSizeH = @imagesy($this->loadedImage);
            if ($this->imageSizeW && $this->imageSizeH)
                return true;
        }
        return false;
    }


    /**
    * Resizes image handler to a specified width.
    *
    * @param    integer     $width  new image width
    * @param    boolean     $anyway Specifies whether to resize even when image smaller then needed
    * @return   boolean
    * @access   public
    */
    function resizeImageToWidth( $width, $anyway = false )
    {
		if ($this->loadedImage)
		{
            if (!$this->imageSizeW && !$this->imageSizeH)
                $this->getImgSizeWH();
            
            if (($width != $this->imageSizeW && $anyway) or ($width < $this->imageSizeW && !$anyway))
            {
                $height = round(($width/$this->imageSizeW) * $this->imageSizeH);

                $img_des = @imageCreateTruecolor($width,$height);
                @imagecopyresampled($img_des, $this->loadedImage, 0, 0, 0, 0, $width, $height, $this->imageSizeW, $this->imageSizeH);
                $this->loadedImage = $img_des;
                $this->getImgSizeWH();
                return true;
            }
        }
        return false;
    }


    /**
    * Resizes image handler to a specified height.
    *
    * @param    integer     $height     new image height
    * @param    boolean     $anyway Specifies whether to resize even when image smaller then needed
    * @return   boolean
    * @access   public
    */
    function resizeImageToHeight( $height, $anyway = false )
    {
        if ($this->loadedImage)
        {
            if (!$this->imageSizeW or !$this->imageSizeH)
                $this->getImgSizeWH();
            
            if (($height != $this->imageSizeH && $anyway) or ($height < $this->imageSizeH && !$anyway))
            {
                $width = round(($height / $this->imageSizeH) * $this->imageSizeW);
                
                $img_des = @imageCreateTruecolor($width,$height);
                @imagecopyresampled($img_des, $this->loadedImage, 0, 0, 0, 0, $width, $height, $this->imageSizeW, $this->imageSizeH);
                $this->loadedImage = $img_des;
                $this->getImgSizeWH();
                return true;
            }
        }
        return false;
    }


    /**
    * Saves image to a file (the same as source) and cleans the variables attached.
    *
    * @param	string		$filename	new filename
    * @param	string		$dir		directory to save in
    * @access	public
    */
    function saveImage( $filename = "", $dir = "" )
    {
        if ($this->loadedImage)
        {
            if ($filename == "")
            {
                if ($dir == "")
                    $newFilename = $this->imageFilename;
                else
                    $newFilename = $dir."/".basename($this->imageFilename).".".$this->imageType;
            }
            else
            {
                if ($dir == "")
                    $newFilename = dirname($this->imageFilename)."/".$filename.".".$this->imageType;
                else
                    $newFilename = $dir."/".$filename.".".$this->imageType;
            }
            
            switch ($this->imageType)
            {
                case "jpg":
                    @imagejpeg($this->loadedImage, $newFilename, $this->jpgQuality);
                    break;

                case "png":
                    @imagepng($this->loadedImage, $newFilename);
                    break;
                
                case "gif":
                    $newFilename = str_replace( ".gif", ".png", $newFilename );
                    @imagepng($this->loadedImage, $newFilename);
                    break;
            }
        }
        else
            return false;
        
        //$this->unloadImage();
    }


    /**
    * Unloads the variables attached to an image.
    *
    * @access	private
    */
    function unloadImage()
    {
        if ($this->loadedImage)
            unset($this->imageFilename, $this->imageType, $this->loadedImage, $this->imageSizeW, $this->imageSizeH);
    }
	

    /**
    * Set maximal allowed image width.
    * 
    * @param    int     $maxWidth   default maximal allowed image width
    * @access	public
    * @see setMaxHeight()
    */
    function setMaxWidth( $maxWidth )
    {
        $this->maxImageW = $maxWidth;
    }
    
    /**
    * Set maximal allowed image height.
    * 
    * @param    int     $maxHeight  default maximal allowed image height
    * @access	public
    * @see setMaxWidth()
    */
    function setMaxHeight( $maxHeight )
    {
        $this->maxImageH = $maxHeight;
    }

    /**
    * Set maximal allowed image size (width and height).
    * 
    * @param    int     $maxWidth   default maximal allowed image width
    * @param    int     $maxHeight  default maximal allowed image height
    * @access	public
    * @see setMaxWidth()
    */
    function setMaxSize( $maxWidth, $maxHeight )
    {
        $this->maxImageW = $maxWidth;
        $this->maxImageH = $maxHeight;
    }

    /**
    * Checks horizontal image size difference.
    *
    * Returns difference between image width and maximal allowed image width.
    * 
    * @access	private
    * @see verSizeDiff()
    */
    function horSizeDiff()
    {
        return $this->imageSizeW - $this->maxImageW;
    }
    
    /**
    * Checks vertical image size difference.
    *
    * Returns difference between image height and maximal allowed image height.
    * 
    * @access	private	
    * @see horSizeDiff()
    */
    function verSizeDiff()
    {
        return $this->imageSizeH - $this->maxImageH;
    }

    /**
    * Process image.
    * 
    * @param    string      $image      path to an image
    * @param    boolean     $save       switch whether to save loaded image after smart resizing
    * @param    string      $filename   new filename
    * @param    string      $dir        directory to save in
    * @param    boolean     $anyway     specifies whether to resize an image even if it smaller then needed
    * @param    string      $image_type specifies the type of saved image (jpg by default)
    * @access   public
    */
    function processImage( $image, $save = false, $filename = "", $dir = "", $anyway = false, $image_type = "jpg" )
    {
        if ( USE_IMAGICK )
            return $this->processImageWithImageMagick( $image, $filename, $dir );
            
        if ($this->loadImage($image))
        {
            $this->getImgSizeWH();
            if ($this->horSizeDiff() > 0 or $anyway)
                $this->resizeImageToWidth($this->maxImageW, $anyway);
            
            if ($this->verSizeDiff() > 0 or $anyway)
                $this->resizeImageToHeight($this->maxImageH, $anyway);
            
            if ($save)
            {
                $this->imageType = $image_type;
                $this->saveImage($filename, $dir);
            }
                
            return true;
		}
		return false;
    }
    
    /**
     * Resizes the given image with ImageMagick tool.
     *
     * @return   boolean
     * @param    string     $image      the path to image to resize
     * @param    string     $filename   the name of resized image (without extension)
     * @param    string     $dir        path for resized image
     * @access   public
     */
    function processImageWithImageMagick( $image, $filename, $dir )
    {
        if ( is_file($dir . $filename . ".jpg") ) unlink($dir . $filename . ".jpg");
        
        $size = getimagesize($image);
        if ($size[0] > $size[1])
        {
            $newWidth = $this->maxImageW;
            $newHeight = round($newWidth * $size[1] / $size[0]);
        }
        else
        {
            $newHeight = $this->maxImageH;
            $newWidth = round($newHeight * $size[0] / $size[1]);
        }
        $exe = ((defined('PHP_OS')) && (preg_match('#win#i', PHP_OS))) ? '.exe' : '';
        $imagick = '';
        
        if (empty($_ENV['MAGICK_HOME']))
        {
            $locations = array(IMAGICK_PATH, 'C:/WINDOWS/', 'C:/WINNT/', 'C:/WINDOWS/SYSTEM/', 'C:/WINNT/SYSTEM/', 'C:/WINDOWS/SYSTEM32/', 'C:/WINNT/SYSTEM32/', '/usr/bin/', '/usr/sbin/', '/usr/local/bin/', '/usr/local/sbin/', '/opt/', '/usr/imagemagick/', '/usr/bin/imagemagick/');
        
            foreach ($locations as $location)
            {
                if (file_exists($location . 'convert' . $exe) && @is_readable($location . 'convert' . $exe))
                {
                    $imagick = $location;
                    break;
                }
            }
        }
        else
        {
            $imagick = str_replace('\\\\', "\\", $_ENV['MAGICK_HOME']) . DIR_SEP;
        }
        
        $command = $imagick . 'convert'.$exe.' -size ' . $size[0] . 'x' . $size[1] . ' "' . $image . '" -resize ' . $newWidth . 'x' . $newHeight . ' -quality ' . $this->jpgQuality . ' +profile "*" "' . $dir . $filename . ".jpg" . '"';
        if ( system($command) )
            return false;
        else 
            return true;
    }
    
    /**
     * Resizes the image to the specified size even if it has another proportions.
     *
     * @return   boolean
     * @param    string      $image      path to an image
     * @param    boolean     $save       switch whether to save loaded image after resizing
     * @param    string      $filename   new filename
     * @param    string      $dir        directory to save in
     * @param    string      $image_type specifies the type of saved image jpg|png
     * @param    int     $var
     * @access   public
     */
    function processImageFixed( $image, $save = false, $filename = "", $dir = "", $image_type = "" )
    {
        if ($this->loadImage($image))
        {
    		if ($this->loadedImage)
    		{
                if (!$this->imageSizeW && !$this->imageSizeH)
                    $this->getImgSizeWH();
                
                $img_des = @imageCreateTruecolor($this->maxImageW, $this->maxImageH);
                @imagecopyresampled($img_des, $this->loadedImage, 0, 0, 0, 0, $this->maxImageW, $this->maxImageH, $this->imageSizeW, $this->imageSizeH);
                $this->loadedImage = $img_des;
                $this->getImgSizeWH();
                
                if ( $save )
                {
                    if ( $image_type )
                        $this->imageType = $image_type;
                    $this->saveImage($filename, $dir);
                }
                
                return true;
            }
        }
        return false;
    }
	
}


?>
