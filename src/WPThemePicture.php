<?php

declare( strict_types = 1 );
namespace WaughJ\WPThemePicture;

use WaughJ\HTMLPicture\HTMLPicture;
use WaughJ\WPThemeImage\WPThemeImage;

class WPThemePicture extends HTMLPicture
{
	public function __construct( string $src, string $extension, $sizes, array $attributes = [] )
	{
		$attributes[ 'loader' ] = WPThemeImage::getFileLoader( $attributes );
		unset( $attributes[ 'directory' ] ); // Make sure we don't keep this as an attribute that gets passed into the HTML itself.
		$picture = self::generate( $src, $extension, $sizes, $attributes );
		parent::__construct( $picture->getFallbackImage(), $picture->getSources(), $picture->getPictureAttributes()->getAttributeValuesMap() );
	}
}
