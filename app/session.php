<?php
if (!isset($_SESSION)) {
    session_set_cookie_params(99999999 , '', $_SERVER['HTTP_HOST']);
    // @TODO: APCIHACK: getting tmp and gc warnings from session_start - suppress.
    @session_start();
}
