<?php

namespace MyShop\AdminBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class GeneratorNameForPhoto
{
	public function generateName()
	{
		return rand(100000,999999999);
	}
}