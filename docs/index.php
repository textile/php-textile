<?php
	
	class sourceFile
	{
		protected $name;
		protected $page_title;
		protected $sort_order;
		protected $source;
		protected $textile;
		
		public function __construct($name, $file_path)
		{
			$this->name = $name;
			if ( file_exists($file_path) )
			{
				$this->source = file_get_contents($file_path);
				$lines = explode("\n", $this->source);
				foreach ( $lines as $line )
				{
					if ( preg_match('/^\s*$/', $line) )
						break;
					foreach ( $this as $meta => $value )
					{
						if ( substr($line, 0, strlen($meta)) === $meta )
						{
							$this->$meta = substr($line, strlen($meta) + strlen(' => '));
						}
					}
				}
			}
			else
				exit;
		}
		
		public function __get($property)
		{
			$getter = 'get_' . $property;
			if ( method_exists($this, $getter) )
				return $this->$getter();
		}
		
		public function get_page_title()
		{
			return $this->page_title;
		}
		
		public function get_sort_order()
		{
			return $this->sort_order;
		}
		
		public function get_name()
		{
			return $this->name;
		}
		
		public function get_code()
		{
			return htmlspecialchars($this->_get_textile());
		}
		
		public function get_web()
		{
			return $this->_get_textile();
		}
		
		public function get_source()
		{
			return $this->source;
		}
		
		private function _get_textile()
		{
			if ( ! $this->textile )
			{
				$textile = new Textile;
				$this->textile = $textile->textileThis($this->source);
			}
			return $this->textile;
		}
		
	}

	define('DOCS_DIR', dirname(__FILE__));
	define('SOURCE_FILE_EXT', 'textile');
	include(dirname(DOCS_DIR) . DIRECTORY_SEPARATOR . 'classTextile.php');
	$files = array();
	$display_modes = array('web', 'code', 'source');
	
	foreach ( scandir(DOCS_DIR) as $file )
		if ( preg_match('/^(.+)\.' . SOURCE_FILE_EXT . '$/', $file, $match) )
			$files[end($match)] = new sourceFile(end($match), DOCS_DIR . DIRECTORY_SEPARATOR . $file);
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
		case 'code':
			echo "<pre><code>\n", $source_file->code, "</code></pre>\n";
			break;
		case 'source':
			echo "<pre>\n", htmlspecialchars($source_file->source), "</pre>\n";
	}

?>
</div>
</body>
</html>
