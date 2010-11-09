<?php
	if(isset($VIEW_HEADER) ) {
		echo '<h1>' . $VIEW_HEADER . '</h1>';	
	}
?>
<table border = "1" cellpadding = '3' cellspacing = '1' width = "70%">
<?php
echo "<tr>";
foreach($LIST['headers'] as $key => $list_header) {
	echo '<td><strong>' . $list_header . '</strong></td>';
}
echo "</tr>";
foreach($LIST['list'] as $key => $row) {
	echo "<tr>";
	foreach($row as $listKey => $content) {
		echo '<td>';
		if (isset($LIST['links'][$listKey] ) ) {
			echo '<a href = "' . $LIST['links'][$listKey] . '/' . $LIST['list'][$key]->id . '">' . $content . '</a>';
		} else {
			echo $content;
		}
		echo '</td>';
	}
	echo "</tr>";
}
?>
</table>
One list view which can be used as reusable view. 