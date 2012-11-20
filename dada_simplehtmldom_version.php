<?php

include 'simple_html_dom.php';
$html = file_get_html($_GET['page']);

if (strlen($_GET['element'] and $_GET['number'])>0) {
		echo '<html>';
		foreach($html->find('head') as $e)
			echo '<head>'.$e->innertext.'<base href="'.$_GET['page'].'" /></head>';
		echo '<body>';
		echo $html->find($_GET['element'], $_GET['number'])->outertext;
		echo '</body>';
		echo '</html>';
}

else {
	foreach($html->find($_GET['element']) as $e => $f)
		echo '<mark>'.$e.$f->outertext.'</mark>';
}

?>
