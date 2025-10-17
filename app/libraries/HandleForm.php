<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

//namespace App;

class HandleForm {
	
    public static function validate($value, $type){
        
		switch ($type) {
            case 'required':
                return !empty($value);
            case 'alphabets':
                //preg_match('/^[a-zA-Z]*$/', $value, $matches);
				preg_match('/^[A-Za-z0-9àâáäçéèèêëìîíïôòóöőùûúüűÄÂÀÁËÊÉÈÎÏÍÔÓŐÛÙÖÜÚŰÆæÇŒœñýẞ]*$/', $value, $matches);
                return !empty($value) && $matches[0];
			case 'username':
				preg_match('/^[A-Za-z0-9àâáäçéèèêëìîíïôòóöőùûúüűÄÂÀÁËÊÉÈÎÏÍÔÓŐÛÙÖÜÚŰÆæÇŒœñýẞ\.\-]{1,}$/', $value, $matches);
                return !empty($value) && $matches[0];
			case 'userpass':
				//if (preg_match('/^(.{0,7}|[^a-z]*|[^\d]*)$/', $value, $matches)) {
				if (preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/', $value, $matches)) {
					//preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $value, $matches);
					//return !empty($value) && $matches[0];
					return true;//!empty($value) && !$matches[0];
				} else {
					return false;
				}
			case 'decimal':
				preg_match('/^[0-9\.]+$/', $value, $matches);
				return !empty($value) && $matches[0];
            case 'numbers':
                preg_match('/^[0-9]*$/', $value, $matches);
                return !empty($value) && $matches[0];
            case 'email':
                /*preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $value, $matches);
                return !empty($value) && $matches[0];
				*/
				return !empty($value) && filter_var($value, FILTER_VALIDATE_EMAIL);
			case 'uri':				/*preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $value , $matches);
				return !empty($value) && $matches[0];*/
				//return !filter_var($URL, FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED);
				return !filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED);
			case 'city':
				preg_match("/^[A-Za-z0-9àâáäçéèèêëìîíïôòóöőùûúüűÄÂÀÁËÊÉÈÎÏÍÔÓŐÛÙÖÜÚŰÆæÇŒœñýẞ\+ ]{1,}$/", $value , $matches);
				return  !empty($value) && $matches[0];
			case 'text': // & ZIP & address
				/*preg_match("/^[A-Za-z0-9àâáäçéèèêëìîíïôòóöőùûúüűÄÂÀÁËÊÉÈÎÏÍÔÓŐÛÙÖÜÚŰÆæÇŒœñýẞ\/\;\.\!\?\s\,\-\#\:\(\)\ ]{1,}$/i", $value , $matches);
				return !empty($value) && $matches[0];*/
				if (preg_match("/^[A-Za-z0-9àâáäçéèèêëìîíïôòóöőùûúüűÄÂÀÁËÊÉÈÎÏÍÔÓŐÛÙÖÜÚŰÆæÇŒœñýẞ\/\;\.\!\?\s\,\-\#\:\(\)\ ]{1,}$/i", $value , $matches) === 1) {
					return !empty($value) && $matches[0];
				} else {
					return false; // vagy valamilyen más értelmes visszatérési érték
				}
			case 'huntax':
				preg_match(
				"/^[0-9]{8}-[0-9]-[0-9]{2}$/"
				, $value , $matches);
			case 'phone':
				preg_match('/^[0-9\-\(\)\/\+\s]*$/', $value , $matches);
				return !empty($value) && $matches[0];			
			case 'password':
				preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $value, $matches);
                return !empty($value) && $matches[0];			
            case 'date(m/d/y)':
                $array = explode("/", $value);
                return !empty($value) && checkdate($array[0], $array[1], $array[2]);
			case 'date(y-m-d)':
                $array = explode("-", $value);
                return !empty($value) && checkdate($array[1], $array[2], $array[0]);
            case 'date(m-d-y)':
                $array = explode("-", $value);
                return !empty($value) && checkdate($array[0], $array[1], $array[2]);
            case 'date(d/m/y)':
                $array = explode("/", $value);
                return !empty($value) && checkdate($array[1], $array[0], $array[2]);
            case 'date(d.m.y)':
                $array = explode(".", $value);
                return !empty($value) && checkdate($array[1], $array[0], $array[2]);
            case 'date(d-m-y)':
                $array = explode("-", $value);
                return !empty($value) && checkdate($array[1], $array[0], $array[2]);
            case 'past':
                return !empty($value) && strtotime($value) < strtotime('now');
            case 'present':
                return !empty($value) && strtotime($value) === strtotime('now');
            case 'future':
                return !empty($value) && strtotime($value) > strtotime('now');
            default:
                return false;
        }
    }
	
	// IT WORKS!
	public static function uploadImage($file, $ext, $size, $path, $uFolder, $quality = 80, $dateStamp = true, $db_path = true, $newWidth = 150 ) {
		$size = isset($size)?$size:5000000;
		$imageTemp = $file["tmp_name"];			
		$fileName = basename($file["name"]); 
		$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
		$NewfileName = bin2hex(random_bytes(8)).'.'.$fileType;	
		
		//$newWidth = 150;
		
		if (!empty($uFolder)) {
			$path .= $uFolder . '/';
		}
		
		
		// CREATE NEW DIRECTORY
		if (!file_exists( $path )) {
			mkdir($path, 0777, true);
		}  			
		
		// ADD FILE TIMESTAMP
		$dateTimeStamp = (($dateStamp)?date('Y-m-d').'-':'');
		
		// FILE UPLOAD DESTINATION
		$destinationFile = $path . $dateTimeStamp . $NewfileName;		
		
		 // Get image info 
		$imgInfo = getimagesize($imageTemp);
		$mime = $imgInfo['mime'];
		
		list($width, $height) = $imgInfo;		

		if (!isset($file["type"])) {
            return [false, 'File does not exist!'];
        }
		
        if (!in_array($fileType, $ext)) {
            return [false, 'Extension error! ('.$ext.')'];
        }
		
		if ($file['size'] > $size) {
            return [false, 'Size error!'];
        }
		
		if ($file['error'] > 0) {
            return [false, 'File error!'];
        }
		
		if ($newWidth !== 0 and $width > $newWidth) {
            
			
            $ratio = $height / $width;
			
            $newHeight = $newWidth * $ratio;
			
            $target1 = $path . '/' . bin2hex(random_bytes(8)).'-temp.' . $fileType;
            move_uploaded_file($imageTemp, $target1);
			
			$newImage = imagecreatetruecolor($newWidth, $newHeight);
			//exit('OK');
			
			switch($mime){ 
				case 'image/jpeg': 
					$image = imagecreatefromjpeg($target1); 
					break; 
				case 'image/png': 
					$image = imagecreatefrompng($target1); 
					break; 
				case 'image/gif': 
					$image = imagecreatefromgif($target1); 
					break; 
				default: 
					$image = imagecreatefromjpeg($target1); 
			}
			
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			
		} else {
			
			switch($mime){ 
			case 'image/jpeg': 
				$newImage = imagecreatefromjpeg($imageTemp); 
				break; 
			case 'image/png': 
				$newImage = imagecreatefrompng($imageTemp); 
				break; 
			case 'image/gif': 
				$newImage = imagecreatefromgif($imageTemp); 
				break; 
			default: 
				$newImage = imagecreatefromjpeg($imageTemp); 
			}
			
		}
				
		// Save image 
		imagejpeg($newImage, $destinationFile, $quality); 
		
		if (isset($target1)) unlink($target1);
		clearstatcache();
		
		$destFile = (($db_path)? substr($destinationFile, 2) : $dateTimeStamp . $NewfileName );
		 
		// Return compressed image 
		return [true, $destFile, $file['name']]; //$destination; 
		 
	 }
	
	 /**
     * Upload file
     *
     * @param string $file ($_FILES['name'])
     * @param array $extensions (like ['jpeg', 'jpg','png'] or ['pdf', 'xml', 'csv'])
     * @param integer $size (size in byte)
     * @param string $target (new file address)
     * @param integer $compressRate (like 85)
     * @param string $baseName (like post slug)
     * @param integer $newWidth (new pixel size for width like 1600, height calculate proportionally)
     * @param string $overlay (overlay PNG image address)
     * @param integer $overlayWidth (overlay PNG image width)
     * @param integer $overlayHeight (overlay PNG image height)
     * @return array (2 elements: false and error message OR true and file address)
     */
    public static function upload($file, $extensions, $size, $target, $compressRate = 100, $baseName = '', $newWidth = 0, $overlay = '', $overlayWidth = 0, $overlayHeight = 0) {
		
        if (!isset($file["type"])) {
            return [false, 'File does not exist!'];
        }

        $temporary = explode('.', $file['name']);
        $fileExtension = end($temporary);
        if (!in_array($fileExtension, $extensions)) {
            return [false, 'Extension error!'];
        }

        if ($file['size'] > $size) {
            return [false, 'Size error!'];
        }

        if ($file['error'] > 0) {
            return [false, 'File error!'];
        }

        $sourcePath = $file['tmp_name'];

        if ($newWidth !== 0) {
            list($width, $height) = getimagesize($file['tmp_name']);
            $ratio = $height / $width;
            $newHeight = $newWidth * $ratio;

            $target1 = $target . $baseName . '-temp.' . $fileExtension;
            move_uploaded_file($sourcePath, $target1);

            $newImage = imagecreatetruecolor($newWidth, $newHeight);
			
            if ($fileExtension == 'png') {
                $oldImage = imagecreatefrompng($target1);
            } elseif ($fileExtension == 'jpeg') {
                $oldImage = imagecreatefromjpeg($target1);
            } elseif ($fileExtension == 'gif') {
                $oldImage = imagecreatefromgif($target1);
            }
            imagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            $target2 = $target1 . $baseName . '.' . $fileExtension;
            imagejpeg($newImage, $target2, 100);
            $overlayImage = imagecreatefrompng($overlay);
            imagecopyresampled($newImage, $overlayImage, 0, 0, 0, 0, $overlayWidth, $overlayHeight, $overlayWidth, $overlayHeight);
            imagejpeg($newImage, $target2, $compressRate);

            unlink($target1);
        } else {
            $target1 = $target . $baseName . '.jpg';
            move_uploaded_file($sourcePath, $target1);
        }

        return [true, $target1];
    }
	
	// Összeg kiírása szöveggel
	public static function num2text($nsz) {

	$hatv=array('','ezer','millió','milliárd','billió','billiard','trillió','trilliard','kvadrillio','kvadrilliárd','kvintillió','kvintilliárd','szextillio','szextilliard','szeptillio','szeptilliard','oktillio','oktilliard','nonillió','nonilliárd','decillió','decilliárd','centillió');

	$tizesek=array('','','harminc','negyven','ötven','hatvan','hetven','nyolcvan','kilencven');

	$szamok=array('egy','kettő','három','négy','öt','hat','hét','nyolc','kilenc');

		$tsz='';
		$ej=($nsz<0?'- ':'');
		$sz=trim(''.floor($nsz));
		$hj=0;
		if ($sz=='0') {
		$tsz='nulla';
		} else {
		while ($sz>'') {
			$hj++;
			$t='';
			$wsz=substr('00'.substr($sz,-3),-3);
			$tizesek[0]=($wsz[2]=='0'?'tíz':'tizen');
			$tizesek[1]=($wsz[2]=='0'?'húsz':'huszon');
			if ($c=$wsz[0]) {
			$t=$szamok[$c-1].'száz';
			}
			if ($c=$wsz[1]) {
			$t.=$tizesek[$c-1];
			}
			if ($c=$wsz[2]) {
			$t.=$szamok[$c-1];
			}
			//$tsz=($t?$t.$hatv[$hj-1]:'').($tsz==''?'':'-').$tsz;
			$tsz=ucwords(($t?$t.$hatv[$hj-1]:'').($tsz==''?'':'-').$tsz);
			$sz=substr($sz,0,-3);
		}
		}
		return $ej.$tsz;
	} 
	
}
