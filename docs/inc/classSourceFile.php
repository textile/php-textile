<?php
	
	class SourceFile
	{
		protected $page_title;
		protected $sort_order;

		private $_name;
		private $_source;
		private $_html;
		private $_textile;
		private $_lang;
		
		public function __construct($name, $file_path, $textile, $lang)
		{
			$this->_name = $name;
			$this->_textile = $textile;
			$this->_lang = $lang;
			if ( file_exists($file_path) )
			{
				$this->_source = file_get_contents($file_path);
				$lines = explode("\n", $this->_source);
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
				exit('File not found');
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
			return $this->_name;
		}
		
		public function get_html()
		{
			return htmlspecialchars($this->_get_html());
		}
		
		public function get_web()
		{
			return $this->_get_html();
		}
		
		public function get_source()
		{
			return $this->_source;
		}
		
		private function _get_html()
		{
			if ( ! $this->_html )
			{
				$this->_html = $this->_textile->textileThis($this->_source);
			}
			return $this->_html;
		}
		
		public function pagelink($mode, $text = '')
		{
			if ( ! $text ) $text = $mode;
			$qs[] = $mode . '=' . $this->_name;
			if ( $this->_lang !== DEFAULT_LANG )
				$qs[] = 'lang=' . $this->_lang;
			$qs = '?' . implode('&amp;', $qs);
			return '<a href="./' . $qs . '">' . $text . '</a>';
		}
		
	}

