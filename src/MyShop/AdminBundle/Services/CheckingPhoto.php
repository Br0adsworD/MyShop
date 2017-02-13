<?php

namespace MyShop\AdminBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CheckingPhoto
{

	/*
	*
	array(3) {
	  [0]=>
	  array(2) {
	    [0]=>
	    string(3) "jpg"
	    [1]=>
	    string(9) "image/jpg"
	  }
	  [1]=>
	  array(2) {
	    [0]=>
	    string(3) "gif"
	    [1]=>
	    string(9) "image/gif"
	  }
	  [2]=>
	  array(2) {
	    [0]=>
	    string(3) "png"
	    [1]=>
	    string(9) "image/png"
	  }
	}

	*/
	private $photoType;

	public function __construct($photoType)
	{
		
		$this->photoType=$photoType;                     
	}

	public function check(UploadedFile $photoFile)
	{
		$checkTrue=false;
		$mimeType=$photoFile->getClientMimeType();
		foreach($this->photoType as $typePhoto)
		{
			if($mimeType ==$typePhoto[1])
				$checkTrue=true;
		}
		if($checkTrue!==true)
			throw new \InvalidArgumentException("Нельзя!");
		$fileExtension=$photoFile->getClientOriginalExtension();
		$checkTrue=false;
		foreach($this->photoType as $typePhoto)
		{
			if($fileExtension==$typePhoto[0])
			{
				$checkTrue=true;
			}
		}
		if($checkTrue!==true)
			throw new \InvalidArgumentException("Нельзя но но");
		return true;
	}
	
}