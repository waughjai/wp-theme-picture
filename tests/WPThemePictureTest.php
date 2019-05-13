<?php

use PHPUnit\Framework\TestCase;
use WaughJ\WPThemePicture\WPThemePicture;

require_once( 'MockWordPress.php' );

class WPThemePictureTest extends TestCase
{
	public function testBasicPicture()
	{
		$picture = new WPThemePicture( 'photo', 'jpg', '320w 240h, 800w 400h, 1200w 800h', [ 'directory' => 'img' ] );
		$this->assertStringContainsString( ' src="https://www.example.com/wp-content/themes/example/img/photo-320x240.jpg', $picture->getHTML() );
		$this->assertStringContainsString( ' media="(max-width:800px)"', $picture->getHTML() );
		$this->assertStringContainsString( ' media="(min-width:801px)"', $picture->getHTML() );
	}

	public function testBasicPictureWithAttributes()
	{
		$picture = new WPThemePicture( 'photo', 'jpg', '320w 240h, 800w 400h, 1200w 800h', [ 'directory' => 'img', 'img-attributes' => [ 'class' => 'img' ], 'source-attributes' => [ 'class' => 'src' ], 'picture-attributes' => [ 'class' => 'pic' ] ] );
		$this->assertStringContainsString( ' src="https://www.example.com/wp-content/themes/example/img/photo-320x240.jpg', $picture->getHTML() );
		$this->assertStringContainsString( ' media="(max-width:800px)"', $picture->getHTML() );
		$this->assertStringContainsString( ' media="(min-width:801px)"', $picture->getHTML() );
		$this->assertStringContainsString( ' class="img"', $picture->getFallbackImage()->getHTML() );
		$this->assertStringContainsString( ' class="src"', $picture->getSources()[ 0 ]->getHTML() );
		$this->assertStringNotContainsString( ' class="img"', $picture->getSources()[ 0 ]->getHTML() );
		$this->assertStringNotContainsString( ' class="src"', $picture->getFallbackImage()->getHTML() );
		$this->assertTrue( $picture->getPictureAttributes()->hasAttribute( 'class' ) );
		$this->assertEquals( 'pic', $picture->getPictureAttributes()->getAttribute( 'class' )->getValue() );
	}

	public function testPictureWithFileLoaderWithoutVersioning()
	{
		$picture = new WPThemePicture( 'photo', 'jpg', '320w 240h, 800w 400h, 1200w 800h', [ 'directory' => 'img', 'show-version' => false ] );
		$this->assertStringContainsString( ' src="https://www.example.com/wp-content/themes/example/img/photo-320x240.jpg"', $picture->getHTML() );
		$this->assertStringNotContainsString( ' src="https://www.example.com/wp-content/themes/example/img/photo-320x240.jpg?m=', $picture->getHTML() );
		$this->assertStringNotContainsString( ' show-version="false"', $picture->getHTML() );
	}
}
