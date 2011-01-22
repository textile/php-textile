<?php
	
	function __autoload($class)
	{
		include 'class' . $class . '.php';
	}

	function is_lang($lang)
	{
		return preg_match('/^[a-z]{2,2}-[a-z]{2,2}$/', $lang);
	}
		
	define('DOCS_DIR', dirname(__FILE__));
	define('SOURCE_FILE_EXT', 'textile');
	set_include_path(get_include_path() . PATH_SEPARATOR . 
		DOCS_DIR . DIRECTORY_SEPARATOR . 'inc' . PATH_SEPARATOR . 
		dirname(DOCS_DIR));
	
	define('DEFAULT_LANG', 'en-gb');
	$langs = array();
	foreach ( scandir(DOCS_DIR) as $file )
		if ( is_dir($file) && is_lang($file) )
			$langs[] = $file;
	if ( isset($_GET['lang']) && is_lang($_GET['lang']) )
		define('LANG', $_GET['lang']);
	else
		define('LANG', DEFAULT_LANG);
	
	$textile = new Textile;
	$files = array();
	$display_modes = array('web', 'html', 'source');
	
	if ( is_dir(LANG) ) 
	{
		foreach ( scandir(LANG) as $file )
			if ( preg_match('/^(.+)\.' . SOURCE_FILE_EXT . '$/', $file, $match) )
				$files[end($match)] = new SourceFile(end($match), LANG . DIRECTORY_SEPARATOR . $file, $textile, LANG);
	}
	
	if ( $files ) 
	{
		if ( isset($files['tagline']) )
		{
			$tagline = clone $files['tagline'];
			unset($files['tagline']);
		}
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
<title>Textile<?php echo $page_title, " ($display_mode)"; ?></title>
<link rel="stylesheet" type="text/css" href="./textile.css" />
</head>
<body>
<?php echo $tagline->web; ?>
<div id="menu">
<?php
	if ( $files )
	{
		echo '<dl id="file-menu">';
		foreach ( $files as $filename => $file )
			if ( $display_page === $file->name )
			{
				echo '<dt class="here">', $file->page_title, '</dt>';
				foreach ( $display_modes as $mode )
					if ( $mode === $display_mode && $display_page === $file->name )
						echo '<dd class="here">', $mode, '</dd>';
					else
						echo '<dd>', $file->pagelink($mode), '</dd>';
			}
			else
				echo '<dt>', $file->pagelink('web', $file->page_title), '</dt>';
		echo '</dl>';
	}
	if ( count($langs) > 1 )
	{
?>
<form name="select_lang" action="./" method="get">
<div>
<input type="hidden" name="<?php echo $display_mode; ?>" value="<?php echo $display_page; ?>" />
<select name="lang" onchange="select_lang.submit()">
<?php
		foreach ( $langs as $lang )
		{
			$selected = $lang === LANG ? ' selected="selected"' : '';
			echo "<option{$selected}>{$lang}</option>\n";
		}
?>
</select>
</div>
</form>
<?php
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
