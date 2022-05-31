<?php


add_filter('tiny_mce_before_init', 'myextensionTinyMCE');
function myextensionTinyMCE( $init )
{
	// Command separated string of extended elements
	$ext = 'span[id|name|class|style]';

	// Add to extended_valid_elements if it alreay exists
	if (isset($init['extended_valid_elements']))
	{
		$init['extended_valid_elements'] .= ',' . $ext;
	} else
	{
		$init['extended_valid_elements'] = $ext;
	}

	// Super important: return $init!
	return $init;
}


function tel_href( $str_phohe = '' )
{
	if (!empty($str_phohe))
	{

		$tel = str_replace(' ', '', $str_phohe);
		$tel = str_replace('.', '', $tel);
		$tel = str_replace(',', '', $tel);
		$tel = str_replace('(', '', $tel);
		$tel = str_replace(')', '', $tel);
		$tel = str_replace('-', '', $tel);
		$tel = str_replace('–', '', $tel);
		$tel = str_replace('+', '', $tel);
		$tel = str_replace('#', '', $tel);

		return 'tel:' . $tel;
	}
}


function lat_lng_str_to_array( $str )
{
	if (!empty($str))
	{
		$ret = array();
		$a = explode(',', $str);
		foreach ($a as $k => $v)
		{
			$ret[] = trim($v);
		}

		$js = 'lat: ' . $ret[0] . ', lng: ' . $ret[0];
		$ret['js'] = $js;
		return $ret;
	} else return false;

}


function kama_excerpt( $args = '' )
{
	global $post;

	$default = array(
		'maxchar' => 350,
		'text' => '',
		'autop' => true,
		'save_tags' => '',
		'more_text' => '...',
	);

	if (is_array($args))
	{
		$_args = $args;
	} else
	{
		parse_str($args, $_args);
	}

	$rg = (object)array_merge($default, $_args);
	if (!$rg->text) $rg->text = $post->post_excerpt ? : $post->post_content;
	$rg = apply_filters('kama_excerpt_args', $rg);

	$text = $rg->text;
	$text = preg_replace('~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text); // убираем блочные шорткоды: [foo]some data[/foo]. Учитывает markdown
	$text = preg_replace('~\[/?[^\]]*\](?!\()~', '', $text); // убираем шоткоды: [singlepic id=3]. Учитывает markdown
	$text = trim($text);

	// <!--more-->
	if (strpos($text, '<!--more-->'))
	{
		preg_match('/(.*)<!--more-->/s', $text, $mm);

		$text = trim($mm[1]);

		$text_append = ' <a href="' . get_permalink($post->ID) . '#more-' . $post->ID . '">' . $rg->more_text . '</a>';
	} // text, excerpt, content
	else
	{
		$text = trim(strip_tags($text, $rg->save_tags));

		// Обрезаем
		if (mb_strlen($text) > $rg->maxchar)
		{
			$text = mb_substr($text, 0, $rg->maxchar);
			$text = preg_replace('~(.*)\s[^\s]*$~s', '\\1 ...', $text); // убираем последнее слово, оно 99% неполное
		}
	}

	if ($rg->autop)
	{
		$text = preg_replace(
			array( "~\r~", "~\n{2,}~", "~\n~", '~</p><br ?/>~' ),
			array( '', '</p><p>', '<br />', '</p>' ),
			$text
		);
	}

	$text = apply_filters('kama_excerpt', $text, $rg);

	if (isset($text_append)) $text .= $text_append;

	return ( $rg->autop && $text ) ? "<p>$text</p>" : $text;
}
