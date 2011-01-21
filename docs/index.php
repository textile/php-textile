<?php
	
	define('DOCS_DIR', dirname(__FILE__));
	define('SOURCE_FILE_EXT', 'textile');
	define('DEFAULT_LANG', 'en-gb');
	defined('LANG') || define('LANG', DEFAULT_LANG);
	
	set_include_path(get_include_path() . PATH_SEPARATOR . 
		DOCS_DIR . DIRECTORY_SEPARATOR . 'inc' . PATH_SEPARATOR . 
		dirname(DOCS_DIR));
	function __autoload($class)
	{
		include 'class' . $class . '.php';
	}
	
	$textile = new Textile;
	$files = array();
	$display_modes = array('web', 'html', 'source');
	
	foreach ( scandir(DOCS_DIR) as $file )
		if ( preg_match('/^(.+)\.' . SOURCE_FILE_EXT . '$/', $file, $match) )
			$files[end($match)] = new sourceFile(end($match), DOCS_DIR . DIRECTORY_SEPARATOR . $file, $textile);
	if ( $files ) 
	{
		foreach ( $files as $file )
			$sort[$file->name] = $file->sort_order;
		array_multisort($sort, $files);
	}
	
	foreach ( $display_modes as $mode )
	{
		if ( isset($_GET[$mode]) )
		{
			if ( ! array_key_exists($_GET[$mode], $files) )
				exit;
			$display_mode = $mode;
			$display_page = $_GET[$mode];
			break;
		}
	}
	
	if ( empty($display_mode) )
	{
		$display_mode = reset($display_modes);
		$display_page = current(array_keys($files));
	}
	$source_file = $files[$display_page];
	$page_title = ': ' . $source_file->page_title;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Textile Viewer<?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href="./textile.css" />
</head>
<body>
<p id="tagline">
<b>TEXTILE:</b> THE HUMANE WEB TEXT GENERATOR
</p>
<div id="menu">
<?php
	if ( $files )
	{
		echo '<dl id="file-menu">';
		foreach ( $files as $filename => $file )
		{
			if ( $display_page === $file->name )
			{
				echo '<dt class="here">', $file->page_title, '</dt>';
				foreach ( $display_modes as $mode )
				{
					if ( $mode === $display_mode && $display_page === $file->name )
						echo '<dd class="here">', $mode, '</dd>';
					else
						echo '<dd><a href="./?', $mode, '=' . $file->name . '">', $mode, '</a>';
				}
			}
			else
				echo '<dt><a href="./?web=', $file->name, '">', $file->page_title, '</a></dt>';
		}
		echo '</dl>';
	}
?>
</div>
<div id="<?php echo $display_mode; ?>">
<?php
	switch ( $display_mode )
	{
		case 'web':
			echo $source_file->web;
			break;
		case 'html':
			echo "<pre><code>\n", $source_file->html, "</code></pre>\n";
			break;
		case 'source':
			echo "<pre>\n", htmlspecialchars($source_file->source), "</pre>\n";
	}

?>
</div>
</body>
</html>
