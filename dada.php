<?php
/**
 * Dada Scissors - a simple PHP script to extract document fragments for use in your html collage.
 * Copyright (C) 2012, Dada Scissors contributors.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author   Marius Stoica <mariustoica@gmail.com>
 *
 * @license  GNU Affero General Public License http://www.gnu.org/licenses/
 */
 
//Get the url query string
$dom = new DOMDocument;
$dom->loadHTMLfile($_GET['url']);

//Get the xpath query string
$xpath = new DOMXPath($dom);
$nodes = $xpath->query($_GET['xpath']);

//Extract and display the document fragment! Here xpath query must be absolute path.
if (preg_match ("/^\/html\/body(\/.*)*\/\[\d\]$/", $_GET['xpath']) || preg_match ("/^\/html\/body(\/.*)*$/", $_GET['xpath'])) {	
	//Remove body and all its children
	$html = $dom->documentElement;
	$body_old = $html->getElementsByTagName('body')->item(0);
	$html->removeChild($body_old);
	//Fix the urls!
	$head = $html->getElementsByTagName('head')->item(0);
	$url_base = $dom->createTextNode('<base href="' . preg_replace('/^(http.+\.\w{2,}\/).*/', '$1', $_GET['url']) . '" />');	
	$head->insertBefore($url_base, $head->firstChild);
	//Create new body element that will hold the fragment from xpath
	$body = $dom->createElement('body');
	$html->appendChild($body);
	$body->appendChild($nodes->item(0));
	//Display the result
	echo htmlspecialchars_decode($dom->saveHtml());
}

//Preview the possible document fragments using a simple, relative xpath query for particular elements,
//like <p> or <div>, that might hold the fragment you need extracted (something like '//p' will do).
//Copy/paste the absolute xpath and reload the page.
//From the user point of view this is the first operation to be made.
else {
	foreach($nodes as $e) {
       echo '<mark>' . $e->getNodePath() . '</mark>' . '<br>' . "\n" . $dom->saveHtml($e) . '<br>' . "\n";
	}
}

?>
