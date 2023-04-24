<?PHP
/**
 *  SmartMVC Framework.
 *  Copyright (C) 2004  Belisar Systems
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with this library; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 *
 */

/**
 * Class for 2-way crypting with the key [<i>utils.crypt.MicaCrypt</i>].
 *
 * @package utils
 * @version 1.00 (06/05/2004)
 * @author unknown
 */

class MicaCrypt {

    /**
     * Construtor for the class.
     *
     * @return  MicaCrypt
     */
	function MicaCrypt()
	{
	}

    /**
     * Encrypt method.
     *
     * @return  string
     * @param   string  $txt        Text for encrypting
     * @param   string  $CRYPT_KEY  The key
     */
	function encrypt($txt,$CRYPT_KEY){
		if (!$txt && $txt != "0"){
			return false;
			exit;
		}
		
		if (!$CRYPT_KEY){
			return false;
			exit;
		}
		
		$kv = strlen($CRYPT_KEY)+5;
		$estr = "";
		$enc = "";
		$key_index = 0;

    	for ($i=0; $i<strlen($txt); $i++) {
			$e= ord($txt{$i});
			$e = $e + ord($CRYPT_KEY{$key_index++});

			if($key_index == strlen($CRYPT_KEY)){
				$key_index=0;
			}

			$e = $e * $kv;
			(double)microtime()*1000000;
			$rstr = chr(rand(65, 90));
			$estr .= "$rstr$e";
		}
		
		return $estr;
	}


    /**
     * Decrypt method.
     *
     * @return  string
     * @param   string  $txt        Text for decrypting
     * @param   string  $CRYPT_KEY  The key
     */
	function decrypt($txt, $CRYPT_KEY){
		if (!$txt && $txt != "0"){
			return false;
			exit;
		}
		
		if (!$CRYPT_KEY){
			return false;
			exit;
		}
		
		$kv = strlen($CRYPT_KEY)+5;
		
		$estr = "";
		$tmp = "";
		$key_index = 0;

		for ($i=0; $i<strlen($txt); $i++) {
			if ( ord($txt{$i}) > 64 && ord($txt{$i}) < 91 ) {
				if ($tmp != "") {
					$tmp = $tmp / $kv;
					$tmp = $tmp - ord($CRYPT_KEY{$key_index++});

					if($key_index == strlen($CRYPT_KEY)){
						$key_index=0;
					}

					$estr .= chr($tmp);
					$tmp = "";
				}
			} else {
				$tmp .= $txt{$i};
			}
		}

		$tmp = $tmp / $kv;
		$tmp = $tmp - ord($CRYPT_KEY{$key_index});
		$estr .= chr($tmp);

		return $estr;
	}	
}

?>
