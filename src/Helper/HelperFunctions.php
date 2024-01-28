<?php

namespace App\Helper;

class HelperFunctions
{
	public static function createSlug($text)
	{
		// Convert the text to lowercase
		$text = strtolower($text);

		// Replace spaces with hyphens
		$text = str_replace(" ", "-", $text);

		// Remove special characters
		$text = preg_replace("/[^a-z0-9\-]/", "", $text);

		// Remove consecutive hyphens
		$text = preg_replace("/-+/", "-", $text);

		// Trim hyphens from the beginning and end
		$text = trim($text, "-");

		return $text;
	}
}
