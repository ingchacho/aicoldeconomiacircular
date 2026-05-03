<?php
    session_start();
    session_destroy();
    header("Location: ?page_id=5");
exit;

