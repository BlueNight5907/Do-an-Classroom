<?php
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0'); //no cache
    session_cache_limiter('private_no_expire');
    if (session_id() != '')// works
        session_destroy();
    // front controller
    header('Location: index.php');
