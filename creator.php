<?php

/**
 * FaviconCreator
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package favicon-creator
 * @author  Emre Can ÖZTAŞ <emrecanoztas@outlook.com>
 * @license http://opensource.org/licenses/MIT  MIT License
 * @link    https://github.com/emrecanoztas/FaviconCreator
 * @version 0.0.1
 */
 
 /**
  * Favicon creator using your uploading image
  */

function faviconCreator() {
	$favicon 	= null;
	$result		= null;
	
	// Favicon saving directory
	$directory 	= 'favicon/';

	// Valid extension for file
	$validExtension = array('jpg', 'jpeg', 'gif', 'png');

	if (!empty($_FILES['file']['name'])) {
		// Get request file data
		$name 	= $_FILES['file']['name'];
		$tmp 	= $_FILES['file']['tmp_name'];
		$size 	= $_FILES['file']['size'];

		// Get request dimension
		$dimension = (int)$_POST['dimension'];

		// Get extension
		$parser 	= explode('.', strtolower(trim($name)));
		$extension 	= end($parser);

		// Check file dimension in valid extension
		if (in_array($extension, $validExtension)){
			switch($extension) {
				case 'jpg':
				case 'jpeg':
					$favicon = imagecreatefromjpeg($tmp);
					break;
				case 'gif':
					$favicon = imagecreatefromgif($tmp);
					break;
				case 'png':
					$favicon = imagecreatefrompng($tmp);
			}
		} else {
			trigger_error('File extension is not valid!', 1024);
		}

		// Get file size (width & height)
		list($width, $height) = getimagesize($tmp);

		// Create file for request dimension
		$creator = imagecreatetruecolor($dimension, $dimension);

		// Sending image convert to created file
		imagecopyresampled($creator, $favicon, 0, 0, 0, 0, $dimension, $dimension, $width, $height);

		// File name for file
		$filename = $directory . $name;

		// Check directory for writable
		if(is_writable($directory)){ 
			// Convert file to jpeg
			imagejpeg($creator, $filename, 100);
			
			// Create image name
			$createNewName = sha1(uniqid(mt_rand(), true));

			// Rename file with .ico extension
			$status = rename($filename, $directory . $createNewName . '.ico');
			
			// Check file name renamed
			if ($status) {
				$result = $directory . $createNewName . '.ico';
			} else  {
				trigger_error('File not created!', 1024);
			}
		} else {
			trigger_error('Directory is not writable!', 256);
		}
	} else {
		trigger_error('File does not empty!', 256);
	}
	
	return($result);
}