<?php
/*
Plugin Name: Simple Sharing
Plugin URI: #
Description: Adds share links for twitter, facebook, and email to blog posts.
Version: 0.1
Author: David Beveridge
Author URI: http://www.nerdyisback.com
License: MIT
*/
/*	Copyright (c) 2010 David Beveridge, Studio DBC

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

error_reporting(-1);

// Create Options pages:


require_once('CustomOptionsPage.php');

$fields = array();
$fields[] = array('type' => 'paragraph', 'name' => 'Please select the locations where you would like the sharing buttons added:');
$fields[] = array('id' => 'post','name' => 'posts', 'type' => 'checkbox','value'=>'1');
$fields[] = array('id' => 'page','name' => 'pages','type' => 'checkbox','value'=>'1');
$fields[] = array('id' => 'archive','name' => 'archives','type' => 'checkbox','value'=>'1');
$fields[] = array('id' => 'category','name' => 'categories','type' => 'checkbox','value'=>'1');
$fields[] = array('id' => 'attachment','name' => 'attachments','type' => 'checkbox','value'=>'1');
$fields[] = array('id' => 'tag','name' => 'posts','type' => 'checkbox','value'=>'1');
$fields[] = array('id' => 'home','name' => 'home page','type' => 'checkbox','value'=>'1');
$fields[] = array('id' => 'search','name' => 'search results','type' => 'checkbox','value'=>'1');

$ssOpts = new CustomOptionspage('options','simplesharing','Simple Sharing','manage_options',$fields);


function simplesharing_add_links($content)	{
	global $ssOpts;
	if(
		(is_single() && $ssOpts->getOption('post')) OR
		(is_page() && $ssOpts->getOption('page')) OR
		(is_archive() && $ssOpts->getOption('archive')) OR
		(is_category() && $ssOpts->getOption('category')) OR
		(is_attachment() && $ssOpts->getOption('attachment')) OR
		(is_tag() && $ssOpts->getOption('tag')) OR
		(is_home() && $ssOpts->getOption('home')) OR
		(is_search() && $ssOpts->getOption('search'))
	)	{
		$content .= '<div class="share">
							Share:
							<a href="http://twitter.com/home?status='.urlencode('Currently Reading '.get_permalink()).'" target="_blank">Twitter</a>,
							<a href="http://www.facebook.com/sharer.php?u='.urlencode(get_permalink()).'" target="_blank">Facebook</a>,
							<a href="mailto:?subject='.urlencode(get_the_title()).'&body='.urlencode(get_permalink()).'">Email</a>
						</div>
		';
	}
	return $content;
}

add_filter('the_content','simplesharing_add_links');
