<?php

//Preview the possible document fragments using an xpath query for 
//particular block elements like <p> or <div> that might hold the text you need extracted
$dom = new DOMDocument;
$dom->loadHTMLfile($_GET['url']);

$xpath = new DOMXPath($dom);
$nodes = $xpath->query($_GET['xpath']);

foreach($nodes as $e) {
       echo '<mark>' . $e->getNodePath() . '</mark>' . '<br>' . "\n" . $dom->saveHtml($e) . '<br>' . "\n";
}

//Extract the fragment with and display the whole html source template

?>