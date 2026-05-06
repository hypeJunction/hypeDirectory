<?php

$query = get_input('member_query');
return elgg_redirect_response("members?query=$query");
