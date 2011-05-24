<form name="advanced_search" method="get" action="<?php echo base_url();?>product/search">
    <div id="search_field">
        <label>Search for food: </label>
        <input type="text" name="q" id="search_term" value="<?php if(isset($q)) echo $q;?>" />
        <input type="submit" id="search_btn" value="Search" />
    </div>

    <ul id="search_filters">
        <li>
            <input type="checkbox" name="filter_usda" value="1" id="id_usda"
                   <?php if(isset($filter_usda)) echo "checked"?>/>
            <label for="id_usda">Search For USDA Foods</label>
        </li>

        <li>
            <input type="checkbox" name="filter_user" value="1" id="id_user"
                   <?php if(isset($filter_user)) echo "checked"?>/>
            <label for="id_user">Search For User Created Meals</label>
        </li>

        <li>
            <input type="checkbox" name="filter_chain" value="1" id="id_chain"
                   <?php if(isset($filter_chain)) echo "checked"?>/>
            <label for="id_chain">Search Food Chain Meals</label>
        </li>
    </ul>
</form>

<hr />