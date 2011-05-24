<?php if ($TOTAL_ROWS > 0): ?>
<ul id="product_result_list">
    <?php foreach($RESULTS as $product):?>
    <li class="product_result_item clearfix">
        <?php if ($product->thumb):
                echo img('/uploads'.$product->image_path.'thumb/'.$product->thumb);
            else:
                echo img('/img/standard/distributor-na-icon-120-120.jpg');
            endif;
        ?>

        <ul class="product_result_description">
            <li><?php echo anchor("product/{$product->product_url}",
                    htmlspecialchars(ucwords($product->name))) ?></li>
            <li>by <?php echo $product->producer ?></li>
        </ul>

        <?php echo anchor("product/{$product->product_url}", 'View Details', array(
            'class'=>'product_detail_button'));?>
    </li>
    <?php endforeach ?>
</ul>

<div class="pagination clearfix">
    <div class="pagination_details pagination_tally">
        Records <?php echo $PAGING['current_page_first'] ?> -
            <?php echo $PAGING['current_page_last'] ?> of
            <?php echo $TOTAL_ROWS; ?>
    </div>

    <div class="pagination_details pagination_links">
        <div class="nextlast">
            <?php if($PAGING['nextpage'])
                echo anchor("product/search/page{$PAGING['nextpage']}?$QUERY_STRING&pp=$PP", 'Next',
                    array('class'=>'pager_next_link'));
            ?>
            <?php if($PAGING['lastpage'])

                echo ' | ', anchor("product/search/page{$PAGING['lastpage']}?$QUERY_STRING&pp=$PP", 'Last',
                    array('class'=>'pager_last_link'));
            ?>
        </div>

        <div class="prevfirst">
            <?php if($PAGING['firstpage'])
                echo anchor("product/search/page{$PAGING['firstpage']}?$QUERY_STRING&pp=$PP", 'First',
                        array('class'=>'pager_first_link')), ' | ';
            ?>
            
            <?php if($PAGING['previouspage'])
                echo anchor("product/search/page{$PAGING['previouspage']}?$QUERY_STRING&pp=$PP", 'Previous',
                        array('class'=>'pager_prev_link'));
            ?>
        </div>
    </div>

    <div class="pagination_details pagination_perlink">
        Items Per Page: 
        <?php echo anchor("product/search/page{$PAGING['current_page']}?$QUERY_STRING&pp=10", '10');?> |

        <?php echo anchor("product/search/page{$PAGING['current_page']}?$QUERY_STRING&pp=20", '20');?> |

        <?php echo anchor("product/search/page{$PAGING['current_page']}?$QUERY_STRING&pp=30", '30');?>
    </div>
</div>

<?php else: ?>
    <p>There are no search results for &quot;<?php echo $Q ?>&quot;.</p>
<?php endif ?>