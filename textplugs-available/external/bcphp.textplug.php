<?php

/**
 * @copyright Copyright (c) Jdlx 2011, https://github.com/jdlx.
 * 
 * Adds support for syntax highlighted PHP code via bcphp. blocks.
 *
 * bcphp. echo "Hello!"; # comment -> syntax highlighted block of php code
 */

// HIGHLIGHTER COLORS
ini_set ('highlight.comment', 'gray');
/*ini_set ('highlight.string',  '#000000');
ini_set ('highlight.keyword', '#FFFFFF');
ini_set ('highlight.bg',      '#FFFFFF');
ini_set ('highlight.default', '#FFFFFF');
ini_set ('highlight.html',    '#FFFFFF');*/

Textile::RegisterBlockHandler( 'bcphp', '_textile_bcphp_block_handler' );

function _textile_bcphp_block_handler( $textile, $tag, $att, $atts, $ext, $cite, $o1, $o2, $content, $c2, $c1, $eat )
{
	if( $tag === 'bcphp' ) 
	{
		if(strpos($atts,'class=') !== false) {
			$atts = str_replace('class="','class="'.$tag.' ',$atts);
		}
		else {
			$atts = ' class="'.$tag.'"';
		}
		$o1 = '<p '.$atts.'>';
		$c1 = '</p>';
		$o2 = $c2 ='';
		$content = '<?php'.$content.' ?>';
		$content = highlight_string($content, TRUE);
		$content = preg_replace('/&lt;\?php/', '', $content, 1);
		$content = preg_replace('/\?&gt;(?!.*\?&gt;)/', '', $content);
		$content = $textile->shelve($content);
	}
	return array($o1, $o2, $content, $c2, $c1, $eat);
}

# End of file
