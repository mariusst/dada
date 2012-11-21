<?php

$dom = new DOMDocument;
$dom->loadHTMLfile($_GET['url']);

$xpath = new DOMXPath($dom);
$nodes = $xpath->query($_GET['xpath']);

//Extract and display the document fragment! Here xpath parameter must be absolute path.
if (preg_match ("/^\/html\/\/body\/(\/.*\/)?\[\d\]$/", $_GET['xpath']) || preg_match ("/^\/html\/\/body\/(\/.*\/)?/", $_GET['xpath'])) {
	//Fix the urls!
	$head = $dom->getElementsByTagName('head');
	$url_base = $dom->createTextNode('<base href="'.$_GET['url'].'" />');
		
	foreach($head as $e) {
		$e->appendChild($url_base);
	}
			
	//Build the page!
	//This can be better: the parents of the selected fragment are not included
        //so their css inherited by the elements of the selected fragment don't applay to the final page;
        //the same with the scripts.
	echo '<html>';
	echo htmlspecialchars_decode($dom->saveHtml($e));
	echo '<body>';
	foreach($nodes as $f) {
		echo $dom->saveHtml($f);
	}
	echo '</body>';
	echo '</html>';
}

//Preview the possible document fragments using an simple xpath query for particular block
//elements like <p> or <div> that might hold the fragment you need extracted. Copy/paste the absolute xpath and reload the page
//From the user point of view this is the first operation to be made.
else {
	foreach($nodes as $e) {
       echo '<mark>' . $e->getNodePath() . '</mark>' . '<br>' . "\n" . $dom->saveHtml($e) . '<br>' . "\n";
	}
}

?>