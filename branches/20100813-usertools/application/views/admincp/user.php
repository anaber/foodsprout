Search for user (email or screen name):

<?php

echo form_open('user/create_user');

echo form_input('search_user', set_value('search_user', ''));

echo ' '.form_submit('submit', 'Search For User');

echo '</form>';

?>