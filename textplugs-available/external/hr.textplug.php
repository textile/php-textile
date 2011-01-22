<?php

Textile::RegisterBlockHandler( 'hr', '_textile_hr_block_handler' );

/**
 * Example block-level plugin for Textile.
 * 
 * Adds support for HTML horizontal rule via hr. blocks.
 *
 * Examples...
 *     hr. -> <hr />
 *     hr(class). Rule title. -> <hr class="class" title="Rule title." />
 */
function _textile_hr_block_handler( $textile, $tag, $att, $atts, $ext, $cite, $o1, $o2, $content, $c2, $c1, $eat )
{
	if( $tag === 'hr' ) 
	{
		$o1 = "<hr$atts";
		$c1 = ' />';
		$o2 = $c2 = '';
		$content = rtrim( $content );
		if( $content !== '' )
		{
			$o2 = ' title="';
			$c2 = '"';
			$content = $textile->shelve($textile->r_encode_html($content));
		}
	}
	return array($o1, $o2, $content, $c2, $c1, $eat);
}

