<script type="text/javascript">
    <?php
        $startRecord = ( $CURRENT_PAGE - 1 )* $DISP_PER_PAGE + 1 ;
        $endRecord = $CURRENT_PAGE* $DISP_PER_PAGE;
        if($endRecord > $TOTAL_RECORD_COUNT)
        {
            $endRecord = $TOTAL_RECORD_COUNT;
        }
        $lastPageNumber = intval(($TOTAL_RECORD_COUNT + $DISP_PER_PAGE - 1 )/$DISP_PER_PAGE);
    ?>

    function pagingLoad(page)
    {
        currentPage = parseInt(<?php echo $CURRENT_PAGE ?>);
        totalRecordCount = parseInt(<?php echo $TOTAL_RECORD_COUNT ?>);
        endRecord = parseInt(<?php echo $endRecord ?>);
        lastPageNumber = parseInt(<?php echo $lastPageNumber ?>);
        dispPerPage = parseInt(<?php echo $DISP_PER_PAGE ?>);
        //newDispPerPage = parseInt($("#recordsPerPageList").val());
		
		/*
        if(dispPerPage != newDispPerPage)
        {
            pagingRefreshPage(page, totalRecordCount, newDispPerPage, endRecord);
            return;
        }
        */

        switch(page)
        {
            case 'first':
              page = 1;
              break;
              
            case 'prev':
              if(currentPage == 1)
              {
                  return;
              }
              page = currentPage - 1;
              break;

            case 'next':
              if(currentPage == lastPageNumber)
              {
                  return;
              }
              page = currentPage + 1;
              break;

            case 'last':
              page = lastPageNumber;
              break;

            default:
              
        }

        //str = "<?php echo $PAGING_CALLBACK ?>/" + page + "/" + newDispPerPage ;
        str = "<?php echo $PAGING_CALLBACK ?>/" + page ;
        window.location = str;
    }
    function pagingRefreshPage(page, totalRecordCount, dispPerPage, endRecord)
    {
        lastPageNumber = parseInt((totalRecordCount + dispPerPage - 1) / dispPerPage);
        currentPage = parseInt((endRecord + 1) / dispPerPage);

        switch(page)
        {
            case 'first':
              page = 1;
              break;

            case 'prev':
              if(currentPage > 1)
              {
                  page = currentPage - 1;
              }
              break;

            case 'next':
              if(currentPage < lastPageNumber)
              {
                  page = currentPage + 1;
              }
               break;

            case 'last':
              page = lastPageNumber;
              break;

            default:
              page = 1;
        }

        str = "<?php echo $PAGING_CALLBACK ?>/" + page + "/" + dispPerPage;
        window.location = str;
    }
</script>

<div style="overflow:auto; padding:5px;margin-top: 20px;">
	<div style="float:left; width:230px; font-size:12px;" id = 'numRecords'>Viewing records <?php echo "$startRecord-$endRecord of $TOTAL_RECORD_COUNT" ?></div>
	<?php
		/*
	?>
	<div style="float:left; width:120px; font-size:12px;" id = 'recordsPerPage' align = "center">
		<select id = "recordsPerPageList">
			<option value = "">--Per Page--</option>
			<?php
				for($i = 10; $i <= 100; $i+=10) {
					echo '<option value = "' . $i . '"';
					if ($i == $DISP_PER_PAGE) {
						echo ' SELECTED';
					}
					echo '>' . $i . '</option>';
				}
			?>
		</select>
	</div>
	<?php
		*/
	?>
	<div style="float:right; width:330px; font-size:12px;" id = 'pagingLinks' align = "center">
		<a href="#" id = "imgFirst" onClick="pagingLoad('first');">First</a> &nbsp;&nbsp;
		<a href="#" id = "imgPrevious"  onClick="pagingLoad('prev');">Previous</a>
                &nbsp;&nbsp;&nbsp; Page <?php echo $CURRENT_PAGE ?> of <?php echo $lastPageNumber ?>  &nbsp;&nbsp;&nbsp;
		<a href="#" id = "imgNext" onClick="pagingLoad('next');">Next</a> &nbsp;&nbsp;
		<a href="#" id = "imgLast" onClick="pagingLoad('last');">Last</a>
	</div>
	
    <div class="clear"></div>
</div>
