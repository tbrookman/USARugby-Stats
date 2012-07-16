<?php
session_name(comp);
session_set_cookie_params(99999999 , '', $_SERVER['HTTP_HOST']);
session_start();
?>