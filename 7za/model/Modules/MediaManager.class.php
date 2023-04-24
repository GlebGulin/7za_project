<?PHP
/**
 * The module for managing files.
 *
 * @version 0.2 15.06.05
 * @author  Alex Koshel <alex@belisar.de>
 */
class MediaManager extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $file_name      = "";
    var $file_id        = 0;
    var $file_type      = "";
    var $file_path      = "";
    var $file_url       = "";
    var $description    = "";
    var $attributes     = "";
    var $title          = "";
    var $name           = "";
    var $type           = "";

    /**
     * Used for linking with a user.
     *
     * @var     int
     */
    var $user_id        = 0;

    /**
     * Used for linking with EBIMOS MTT item.
     *
     * @var     int
     */
    var $mtt_id         = 0;

    /**
     * Used for grouping MM files.
     *
     * @var     string
     */
    var $group          = "";

    var $errorMsg       = "";

    /**
     * Allowed for handling file types (see the constructor).
     *
     * @var     array
     */
    var $fileTypes      = array();

    /**
     * Full path to the directory where MM files stored.
     *
     * @var     string
     */
    var $filesRoot      = MM_ROOT;

    /**
     * Full URL to the directory with MM files.
     *
     * @var     string
     */
    var $filesUrlRoot   = MM_URL_ROOT;

    /**
     * The max width image should be resized to.
     *
     * @var     int
     */
    var $maxImageWidth  = 500;

    /**
     * The max height image should be resized to.
     *
     * @var     int
     */
    var $maxImageHeight = 400;

    var $maxThumbWidth  = 125;
    var $maxThumbHeight = 125;

    var $start_date     = "";
    var $end_date       = "";

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function MediaManager()
    {
        parent::wrapper();

        $this->fileTypes = array(
            "jpg"   => "image",
            "jpeg"  => "image",
            "gif"   => "image",
            "png"   => "image",
            "swf"   => "image",
            "txt"   => "document",
            "doc"   => "document",
            "xls"   => "document",
            "pdf"   => "document",
            "zip"   => "archive"
        );
    }

    /**
     * Saves uploaded file.
     *
     * If the file extension doesn't fit to $this->fileTypes array, it failed.
     * Returns integer ID of just saved file or false if failed.
     *
     * @param   string  $name           the name of a form item with file
     * @param   string  $type           type: offer|demand|mediation|global
     * @param   string  $title          title for a file
     * @param   string  $description    description for a file
     * @return  int
     * @access  public
     */
    function addFile( $name, $type = "global", $title = "", $description = "" )
    {
        if ( is_uploaded_file( $_FILES[$name]["tmp_name"] ) )
        {
            $this->file_name = addslashes( $_FILES[$name]["name"] );

            // determining the type of a file and exit if unknown type
            $file_ext = $this->getFileExtension($this->file_name);
            if (!$this->file_type = $this->getFileTypeByExtension( $file_ext ) )
                return 0;

            $this->type = $type;

            if ( !empty($title) )
                $this->setTitle( $title );

            if ( !empty($description) )
                $this->setDescription( $description );

            $file_id = $this->getNextAutoIncrement( '#__mm_files' );

            $this->file_path    = $file_id . "." . $file_ext;
            $this->file_url     = $file_id . "." . $file_ext;

            if ( !is_writable($this->filesRoot) )
                $this->addDebugMsg("The directory ".$this->filesRoot." doesn't exist or not writable!", __FILE__ . ':' . __LINE__ );

            // check whether the file exist and delete it if exists
            if ( is_file($this->filesRoot . $this->file_path) )
                unlink($this->filesRoot . $this->file_path);

            // copying the file
            if ( !copy($_FILES[$name]["tmp_name"], $this->filesRoot . $this->file_path) )
                return 0;

            MediaManager::runQuery( 0, "none", __FILE__ . ':' . __LINE__ );
            return $file_id;
        }
        else
            return 0;
    }

    /**
     * Returns an extension of a file - a part of a filename after last dot.
     *
     * @return   string
     * @param    string     $file_name
     * @access   public
     */
    function getFileExtension( $file_name )
    {
        if ( is_integer( strpos( $file_name, "." ) ) )
            return strtolower( substr($file_name, strrpos($file_name, ".")+1) );
        else
            return false;
    }

    /**
     * Determines the file type by given file extension.
     *
     * @return   string
     * @param    string     $file_ext
     * @access   public
     */
    function getFileTypeByExtension( $file_ext )
    {
        $file_ext = strtolower( $file_ext );
        if ( isset($this->fileTypes[ $file_ext ]) )
            return $this->fileTypes[ $file_ext ];
        else
            return false;
    }

    /**
     * Set title for the file.
     *
     * @return   void
     * @param    string     $title
     * @access   public
     */
    function setTitle( $title )
    {
        $this->title = addslashes( $title );
    }

    /**
     * Set a description for the file.
     *
     * @return   void
     * @param    string     $description
     * @access   public
     */
    function setDescription( $description )
    {
        $this->description = addslashes( $description );
    }

    /**
     * Set attributes for the file.
     *
     * Kept serialized in the database. You may use for this parameter any type,
     * but recommended type is array.
     *
     * @return   void
     * @param    mixed     $attributes
     * @access   public
     */
    function setAttributes( $attributes )
    {
        $this->attributes = addslashes( serialize($attributes) );
    }

    /**
     * Set a user_id for the file.
     *
     * @return   void
     * @param    int     $user_id
     * @access   public
     */
    function setUser( $user_id )
    {
        $this->user_id = $user_id;
    }

    /**
     * Set mtt_id value for the file.
     *
     * @return   void
     * @param    int     $mtt_id
     * @access   public
     */
    function setMTT( $mtt_id )
    {
        $this->mtt_id = $mtt_id;
    }

    /**
     * Set group for the file.
     *
     * @return   void
     * @param    string     $group
     * @access   public
     */
    function setGroup( $group )
    {
        $this->group = addslashes($group);
    }

    /**
     * Returns a file record by file id.
     *
     * @return   array
     * @param    int        $file_id
     * @access   public
     */
    function getFile( $file_id )
    {
        $this->file_id = $file_id;
        $file = MediaManager::runQuery( 1, "getArray", __FILE__ . ':' . __LINE__ );

        if ( is_array($file) )
        {
            $file["file"]       = $file["file_path"];
            $file["file_path"]  = $this->filesRoot . $file["file_path"];
            $file["file_url"]   = $this->filesUrlRoot . $file["file_url"];
            if ( !empty($file["attributes"]) )
                $file["attributes"] = unserialize($file["attributes"]);
        }

        return $file;
    }

    /**
     * Removes file.
     *
     * @return   void
     * @param    int        $file_id
     * @access   public
     */
    function deleteFile( $file_id )
    {
        if ( $file_id == 0 )
            return false;

        $file = $this->getFile($file_id);

        if ( is_array($file) )
        {
            // removing the file itself
            if ( is_file($file["file_path"]) )
                unlink($file["file_path"]);

            // removing the thumbnail if exists
            if ( is_file($this->filesRoot . $file["file_id"] . "t.jpg") )
                unlink($this->filesRoot . $file["file_id"] . "t.jpg");

            // removing a db record
            $this->file_id = $file_id;
            MediaManager::runQuery( 2, "none", __FILE__ . ':' . __LINE__ );
            return true;
        }
        else
            return false;
    }

    /**
     * Saves the image.
     *
     * If the file is not image, it failed.
     * Returns integer ID of just saved file or false if failed.
     *
     * @param   string  $name           the name of a form item with file
     * @param   string  $type           type: offer|demand|mediation|global
     * @param   string  $title          title for an image
     * @param   string  $description    description for an image
     * @param   boolean $make_thumb     whether to create a thumbnail
     * @return  int
     * @access  public
     */
    function addImageResized( $name, $type = "global", $title = "", $description = "", $make_thumb = false )
    {
        if ( isset($_FILES[$name]) && is_uploaded_file($_FILES[$name]["tmp_name"]) )
        {
            $this->file_name = addslashes( $_FILES[$name]["name"] );

            // determining the type of a file and exit if it's not an image
            $file_ext = $this->getFileExtension($this->file_name);
            $this->file_type = $this->getFileTypeByExtension( $file_ext );
            if ( $this->file_type != "image" )
                return 0;

            $this->type = $type;

            if ( !empty($title) )
                $this->setTitle( $title );

            if ( !empty($description) )
                $this->setDescription( $description );

            $file_id = $this->getNextAutoIncrement( '#__mm_files' );

            if ( !is_writable($this->filesRoot) )
                $this->addDebugMsg("The directory ".$this->filesRoot." doesn't exist or not writable!", __FILE__ . ':' . __LINE__ );

            // check whether the file with such name already exists
            if ( is_file($this->filesRoot . $file_id . ".jpg") )
                unlink($this->filesRoot . $file_id . ".jpg");

            // check whether the thumb already exists
            if ( is_file($this->filesRoot . $file_id . "t.jpg") )
                unlink($this->filesRoot . $file_id . "t.jpg");

            $SR =& $this->getClassOf("utils.image.gd.SmartResize");
            $SR->setMaxSize( $this->maxImageWidth, $this->maxImageHeight );
            if ( !$SR->processImage($_FILES[$name]["tmp_name"], true, $file_id, $this->filesRoot) )
            {
                $this->addDebugMsg("Cannot save file!", __FILE__ . ':' . __LINE__ );
                return 0;
            }

            // saving the thumbnail if required
            if ( $make_thumb )
            {
                $SR->setMaxSize( $this->maxThumbWidth, $this->maxThumbHeight );
                if ( !$SR->processImage($_FILES[$name]["tmp_name"], true, $file_id . 't', $this->filesRoot) )
                    return 0;
            }

            // all resized images saved in jpeg format
            $this->file_path = $file_id . ".jpg";
            $this->file_url  = $file_id . ".jpg";

            MediaManager::runQuery( 0, "none", __FILE__ . ':' . __LINE__ );

            return $file_id;
        }
        else
            return 0;
    }

    /**
     * Saves resized image with a small preview.
     *
     * @return   int
     * @param    string  $name           the name of a form item with file
     * @param    string  $type           type: offer|demand|mediation|global
     * @param    string  $title          title for an image
     * @param    string  $description    description for an image
     * @access   public
     */
    function addImageResizedWithPreview( $name, $type="global", $title = "", $description = "" )
    {
        return $this->addImageResized($name, $type, $title, $description, true);
    }

    function addImageResizedWithPreviewMulti( $name, $type="global", $title = "", $description = "" )
    {
        return $this->addImageResizedMulti($name, $type, $title, $description, true);
    }

    function addImageResizedMulti( $name, $type = "global", $title = "", $description = "", $make_thumb = false )
    {
    	$f_tmp_name = isset( $_FILES[$name]["tmp_name"] ) ? $_FILES[$name]["tmp_name"] : "";
    	$f_name = isset( $_FILES[$name]["name"] ) ? $_FILES[$name]["name"] : "";

    	if( is_array($f_tmp_name) )
    	{
    		$file_ids = array();
    		foreach( $f_tmp_name as $key => $value )
    		{
    			$_FILES[$name]["tmp_name"] = $f_tmp_name[$key];
    			$_FILES[$name]["name"] = $f_name[$key];
    			if ( $file_id = $this->addImageResized( $name, $type , $title , $description , $make_thumb ) )
    				$file_ids[] = $file_id;
    		}
    		return $file_ids;
    	}

        if ( is_uploaded_file($f_tmp_name) )
        {
            $this->file_name = addslashes( $f_name );

            // determining the type of a file and exit if it's not an image
            $file_ext = $this->getFileExtension($this->file_name);
            $this->file_type = $this->getFileTypeByExtension( $file_ext );
            if ( $this->file_type != "image" )
                return 0;

            $this->type = $type;

            if ( !empty($title) )
                $this->setTitle( $title );

            if ( !empty($description) )
                $this->setDescription( $description );

            $file_id = $this->getNextAutoIncrement( '#__mm_files' );

            if ( !is_writable($this->filesRoot) )
                $this->addDebugMsg("The directory ".$this->filesRoot." doesn't exist or not writable!", __FILE__ . ':' . __LINE__ );

            // check whether the file with such name already exists
            if ( is_file($this->filesRoot . $file_id . ".jpg") )
                unlink($this->filesRoot . $file_id . ".jpg");

            // check whether the thumb already exists
            if ( is_file($this->filesRoot . $file_id . "t.jpg") )
                unlink($this->filesRoot . $file_id . "t.jpg");

            $SR =& $this->getClassOf("utils.image.gd.SmartResize");
            $SR->setMaxSize( $this->maxImageWidth, $this->maxImageHeight );
            if ( !$SR->processImage($f_tmp_name, true, $file_id, $this->filesRoot) )
            {
                $this->addDebugMsg("Cannot save file!", __FILE__ . ':' . __LINE__ );
                return 0;
            }

            // saving the thumbnail if required
            if ( $make_thumb )
            {
                $SR->setMaxSize( $this->maxThumbWidth, $this->maxThumbHeight );
                if ( !$SR->processImage($f_tmp_name, true, $file_id . 't', $this->filesRoot) )
                    return 0;
            }

            // all resized images saved in jpeg format
            $this->file_path = $file_id . ".jpg";
            $this->file_url  = $file_id . ".jpg";

            MediaManager::runQuery( 0, "none", __FILE__ . ':' . __LINE__ );

            return $file_id;
        }
        else
            return 0;
    }

    /**
     * Set width and height for resized image.
     *
     * @return   void
     * @param    int     $max_width
     * @param    int     $max_height
     * @access   public
     */
    function setImageSize( $max_width, $max_height )
    {
        $this->maxImageWidth  = $max_width;
        $this->maxImageHeight = $max_height;
    }

    /**
     * Set width and height for a thumbnail.
     *
     * @return   void
     * @param    int     $max_width
     * @param    int     $max_height
     * @access   public
     */
    function setThumbnailSize( $max_width, $max_height )
    {
        $this->maxThumbWidth  = $max_width;
        $this->maxThumbHeight = $max_height;
    }

    /**
     * Returns the file info with specific for images details.
     *
     * The method uses getFile function and appends such additional fields:
     * $image["width"]<br>
     * $image["height"]
     *
     * @return   array
     * @param    int     $file_id
     * @access   public
     */
    function getImage( $file_id )
    {
        $file = $this->getFile($file_id);

        // add width and height values for an image
        $file = $this->addImageInfo($file);

        return $file;
    }

    /**
     * Updates file info.
     *
     * @return   void
     * @param    int     $file_id
     * @param    string  $title
     * @param    string  $description
     * @access   public
     */
    function updateFileDetails( $file_id, $title, $description = "" )
    {
        $file = $this->getFile($file_id);
        if ( $file )
        {
            $this->title = $title;
            if ( $description )
                $this->description = $description;
            else
                $this->description = $file["description"];

            $this->file_id = $file_id;
            MediaManager::runQuery( 7, "none", __FILE__ . ':' . __LINE__ );
        }
    }

    /**
     * Adds image's features to the file array.
     *
     * @return   array
     * @param    array  $file
     * @access   private
     */
    function addImageInfo( $file )
    {
        if ( is_array($file) && $file["file_type"] == "image" && is_file($file["file_path"]) )
        {
            $size = getimagesize($file["file_path"]);
            if ( is_array($size) )
            {
                $file["width"]  = $size[0];
                $file["height"] = $size[1];
            }

            // add thumbnail info if exists
            if ( is_file($this->filesRoot . $file["file_id"] . "t.jpg") )
            {
                $size = getimagesize($this->filesRoot . $file["file_id"] . "t.jpg");
                if ( is_array($size) )
                {
                    $file["thumb_file"]   = $this->filesUrlRoot . $file["file_id"] . "t.jpg";
                    $file["thumb_width"]  = $size[0];
                    $file["thumb_height"] = $size[1];
                }
            }
        }

        return $file;
    }

    /**
     * Adds image info to given record with file_id.
     *
     * @return   array
     * @param    array      $item                   record with a FK to image
     * @param    string     $field_with_file_id     the name of a field with file_id
     * @param    string     $field_name             the name of a field where to store info
     * @access   public
     */
    function addImageInfoToArray( $item, $field_with_file_id, $field_name = "image" )
    {
        if ( isset($item[$field_with_file_id]) )
            $item[$field_name] = $this->getImage($item[$field_with_file_id]);

        return $item;
    }

    /**
     * Adds image info to a set of records.
     *
     * @return   array
     * @param    array      $items                  array of records with a FK to image
     * @param    string     $field_with_file_id     the name of a field with file_id
     * @param    string     $field_name             the name of a field where to store info
     * @access   public
     */
    function addImageInfoToIndexArray( $items, $field_with_file_id, $field_name = "image" )
    {
        for ( $i = 0; $i < count($items); $i++ )
            $items[$i] = $this->addImageInfoToArray($items[$i], $field_with_file_id, $field_name );

        return $items;
    }


/****************************************************************************
 *                    Useful methods for getting file records               *
 ****************************************************************************/

    /**
     * Returns an array with files which were added during specified time interval.
     *
     * Boundary dates should be specified as string "YYYY-MM-DD HH:MM:SS" or as unix
     * timestamp. If the second date omitted, the current time will be taken.
     *
     * @return   array
     * @param    string     $start_date     begin of the interval
     * @param    string     $end_date       end of the interval
     * @access   public
     */
    function getFilesForTimeInterval( $start_date, $end_date = 0 )
    {
        if ( is_integer($start_date) )
            $this->start_date = date("Y-m-d H:i:s", $start_date);
        else
            $this->start_date = $start_date;

        if ( $end_date == 0 )
            $this->end_date = date("Y-m-d H:i:s");
        elseif ( is_integer($end_date) )
            $this->end_date = date("Y-m-d H:i:s", $end_date);
        else
            $this->end_date = $end_date;

        $files = MediaManager::runQuery( 3, "getIndexArray", __FILE__ . ':' . __LINE__ );

        // add image's features for files of image type
        for ( $i = 0; $i < count($files); $i++ )
            $files[$i] = $this->addImageInfo($files[$i]);

        return $files;
    }

    /**
     * Returns files of specified user.
     *
     * @return   array
     * @param    int     $user_id
     * @access   public
     */
    function getFilesByUser( $user_id )
    {
        $this->user_id = $user_id;
        $files = MediaManager::runQuery( 4, "getIndexArray", __FILE__ . ':' . __LINE__ );

        // add image's features for files of image type
        for ( $i = 0; $i < count($files); $i++ )
            $files[$i] = $this->addImageInfo($files[$i]);

        return $files;
    }

    /**
     * Returns all files of specified mtt_id.
     *
     * @return   array
     * @param    int     $mtt_id
     * @access   public
     */
    function getFilesByMTT( $mtt_id )
    {
        $this->mtt_id = $mtt_id;
        $files = MediaManager::runQuery( 5, "getIndexArray", __FILE__ . ':' . __LINE__ );

        // add image's features for files of image type
        for ( $i = 0; $i < count($files); $i++ )
            $files[$i] = $this->addImageInfo($files[$i]);

        return $files;
    }

    /**
     * Returns all files of specified group.
     *
     * @return   array
     * @param    string     $group
     * @access   public
     */
    function getFilesByGroup( $group )
    {
        $this->group = addslashes($group);
        $files = MediaManager::runQuery( 6, "getIndexArray", __FILE__ . ':' . __LINE__ );

        // add image's features for files of image type
        for ( $i = 0; $i < count($files); $i++ )
            $files[$i] = $this->addImageInfo($files[$i]);

        return $files;
    }

    /**
     * Removes all files of specified user.
     *
     * @return   void
     * @param    int     $user_id
     * @access   public
     */
    function deleteFilesOfUser( $user_id )
    {
        $files = $this->getFilesByUser($user_id);

        for ( $i = 0; $i < count($files); $i++ )
            $this->deleteFile($files[$i]["file_id"]);
    }

    /**
     * Removes all files of specified MTT.
     *
     * @return   void
     * @param    int     $mtt_id
     * @access   public
     */
    function deleteFilesOfMTT( $mtt_id )
    {
        $files = $this->getFilesByMTT($mtt_id);

        for ( $i = 0; $i < count($files); $i++ )
            $this->deleteFile($files[$i]["file_id"]);
    }

    /**
     * Removes all files of specified group.
     *
     * @return   void
     * @param    string     $group
     * @access   public
     */
    function deleteFilesOfGroup( $group )
    {
        $files = $this->getFilesByGroup($group);

        for ( $i = 0; $i < count($files); $i++ )
            $this->deleteFile($files[$i]["file_id"]);
    }

/****************************************************************************
 *                      The method for module installation                  *
 ****************************************************************************/

    /**
     * Register the module in the application.
     *
     * @return   void
     * @param    string  $app_name
     * @access   public
     */
    function installModule( $app_name )
    {
        $accounts   =& $this->getClassOf("EBIMOS.Accounts");
        $ML         =& $this->getClassOf("EBIMOS.MultiLanguage");
        $accounts->addAccountableProperty(  $ML->addMessage("Upload file"), // the name of a property
                                            $app_name,                      // application name
                                            "MediaManager",                 // module name
                                            "",                             // module identifier
                                            "global",                       // type
                                            "upload_file"                   // property key
                                           );
    }

/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/

    /**
     * wrapper around the runQuery method in dbHandler.class.php
     */
    function runQuery( $query_id, $result, $msg_id ) {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        return $this->core->runQuery( $query[$query_id], $result, $msg_id );
    }

}
?>