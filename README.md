WP Theme Picture
=========================

Class for autogenerating picture tag HTML for WordPress theme image.

Works just like HTMLPicture, but automatically applies WPThemeImage directory rather than expecting users to supply their own.

For a theme named “example” setup on https://www.example.com:

    use WaughJ\WPThemePicture\WPThemePicture;

    $picture = new WPThemePicture( 'photo', 'jpg', '320w 240h, 800w 400h, 1200w 800h', [ 'directory' => 'img' ] );
    $picture->print();

    //    Will print out the following ( #s after m?= will vary ):
    //    <picture>
    //        <source srcset="https://www.example.com/wp-content/themes/example/img/photo-320x240.jpg?m=1554999461" media="(max-width:320px)">
    //        <source srcset="https://www.example.com/wp-content/themes/example/img/photo-800x400.jpg?m=1554999461" media="(max-width:800px)">
    //        <source srcset="https://www.example.com/wp-content/themes/example/img/photo-1200x800.jpg?m=1554999461" media="(min-width:801px)">
    //        <img src="https://www.example.com/wp-content/themes/example/img/photo-320x240.jpg?m=1554999461" alt="" />
    //    </picture>

Like HTMLPicture, this will throw a MissingFileException if versioning is set on ( the default ) & the server can’t find the file. Look @ the HTMLPicture documentation for mo’ information.

An easy way to deal with exceptions:

    use WaughJ\FileLoader\MissingFileException;
    use WaughJ\WPThemePicture\WPThemePicture;

	try
	{
		$picture = new WPThemePicture( 'photo', 'jpg', '320w 240h, 800w 400h, 1200w 800h, 2400w 600h', [ 'directory' => 'img' ] );
	}
	catch ( MissingFileException $e )
	{
		$picture = $e->getFallbackContent();
	}

    $picture->print(); // Will print without versioning for files that can’t be found & won’t throw exception.
