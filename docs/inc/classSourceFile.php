<?php
	
	class SourceFile
	{
		protected $name;
		protected $page_title;
		protected $sort_order;
		protected $source;
		protected $html;
		private $textile;
		
		public function __construct($name, $file_path, $textile)
		{
			$this->name = $name;
			$this->textile = $textile;
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
			return htmlspecialchars($this->_get_html());
		}
		
		public function get_web()
		{
			return $this->_get_html();
		}
		
		public function get_source()
		{
			return $this->source;
		}
		
		private function _get_html()
		{
			if ( ! $this->html )
			{
				$this->html = $this->textile->textileThis($this->source);
			}
			return $this->html;
		}
		
	}

