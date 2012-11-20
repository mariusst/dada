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

//add to each elemnt the display=hidden atribute eccept the elemnt queried.
//if (strlen($html->find($z)->plaintext)>0) {}
?>

<!--
<form action="" method="get">
   <input name="page" type="hidden" />
   <input name="element" value="Enter a string!" />
   <input name="number" value="Enter the number of the counted html element!" />
   <input type="submit" value="Submit" />
</form>
-->
