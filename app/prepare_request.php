<?php
use Symfony\Component\HttpFoundation\Request;
require_once __DIR__.'/../vendor/autoload.php';
if (empty($request)) {
  $request = Request::createFromGlobals();
}