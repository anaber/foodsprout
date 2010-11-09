<div style="overflow:auto; padding:5px;">
	
	<div style="float:left; width:250px; font-size:12px;" id = 'numRecords'>Viewing records 0-0 of 0</div>
	<div style="float:left; width:120px; font-size:12px;" id = 'recordsPerPage' align = "center">
		<select id = "recordsPerPageList">
			<option value = "">--Per Page--</option>
			<?php
				for($i = 10; $i <= 100; $i+=10) {
					echo '<option value = "' . $i . '"';
					if ($i == 10) {
						echo ' SELECTED';
					}
					echo '>' . $i . '</option>';
				}
			?>

		</select>
	</div>
	<div style="float:left; width:350px; font-size:12px;" id = 'pagingLinks' align = "center">
		<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;
		<a href="#" id = "imgPrevious">Previous</a>
		&nbsp;&nbsp;&nbsp; Page 1 of 1 &nbsp;&nbsp;&nbsp;
		<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;
		<a href="#" id = "imgLast">Last</a>
	</div>
	
	<div style="float:left; width:225px; font-size:12px;" id = 'searchBox' align = "right"><input type = "text" name = "suggestion_box" id = "suggestion_box" size = "30"></div>
	
	<div class="clear"></div>
</div>

<h2 class="blue_text first" id="messageContainer" align = "center">Your search results are loading, please wait.</h2>

<div id="resultsContainer" style="display:none" class="pd_tp1">
	<div id="resultTableContainer"></div>
</div>