<?php
use Symfony\Component\HttpFoundation\Tests\RequestContentProxy;
use Symfony\Component\HttpFoundation\Request;
use Guzzle\Http\Client;
use Guzzle\Http\Plugin\OauthPlugin;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// register the session extension
$app->register(new Silex\Provider\SessionServiceProvider());

// Setup app default settings
$app->before(function (Request $request) use($app) {
  // Include configuration file.
  include_once './config.php';

  $app['session']->start();
  $domain = $app['session']->get('domain');
  if ($domain == null) {
    if ($env = $config['auth_domain']) {
      $app['session']->set('domain', $env);
    }
    else {
      $app['session']->set('domain', 'https://www.allplayers.com');
    }
  }
  $consumer_key = $app['session']->get('consumer_key');
  if ($consumer_key == null) {
    if ($key = $request->query->get('key')) {
      $secret = $request->query->get('secret');
      $app['session']->set('consumer_key', $key);
      $app['session']->set('consumer_secret', $secret);
    }
    else {
      $app['session']->set('consumer_key', $config['consumer_key']);
      $app['session']->set('consumer_secret', $config['consumer_secret']);
    }
  }
});

$app->get('/', function() use($app) {
  $app['session']->start();
  $info = '<br /> Context: ' . $app['session']->get('domain');
  if (($token = $app['session']->get('auth_token')) == null) {
    return 'Welcome Guest. <a href="/login">Login</a>' . $info;
  } else {
    $temp_token = $app['session']->get('access_token');
    $temp_secret = $app['session']->get('access_secret');
    $secret = $app['session']->get('auth_secret');

    // Pass session info to the legacy app

    // twig/template this section
    // HACK perform access check on Matts app
    if(!(isset($_SESSION['user']) && $_SESSION['user'])) {
      return $app->redirect('/login.php');
    }
    include_once ('./include.php');
    echo "<h1>Welcome to USA Rugby's National Championship Series!</h1>";

    if (editCheck(1)) {
      echo "<a href='add_comp.php'>Add New Competition</a><br/>\r";
    }

    //List our comps
    echo "<h2>Competitions</h2>";
    echo "<div id='comps'>";
    include_once ('./comp_list.php');
    echo "</div>";
    include_once ('./footer.php');
    mysql_close();
    return '';
  }
});

$app->get('/login', function(Request $request) use ($app) {
  $app['session']->start();
  // check if the user is already logged-in
  if (null !== ($username = $app['session']->get('username'))) {
    return $app->redirect('/');
  }

  $client = new Client($app['session']->get('domain') . '/oauth', array(
    'curl.CURLOPT_SSL_VERIFYPEER' => TRUE,
    'curl.CURLOPT_CAINFO' => 'assets/mozilla.pem',
    'curl.CURLOPT_FOLLOWLOCATION' => FALSE,
  ));

  $oauth = new OauthPlugin(array(
    'consumer_key' => $app['session']->get('consumer_key'),
    'consumer_secret' => $app['session']->get('consumer_secret'),
    'token' => FALSE,
    'token_secret' => FALSE,
  ));

  // if $request path !set then set to request_token
  $timestamp = time();
  $params = $oauth->getParamsToSign($client->get('request_token'), $timestamp);
  $params['oauth_signature'] = $oauth->getSignature($client->get('request_token'), $timestamp);
  $response = $client->get('request_token?' . http_build_query($params))->send();

  // Parse oauth tokens from response object
  $oauth_tokens = array();
  parse_str($response->getBody(TRUE), $oauth_tokens);
  $app['session']->set('access_token', $oauth_tokens['oauth_token']);
  $app['session']->set('access_secret', $oauth_tokens['oauth_token_secret']);

  $authorize = '/oauth/authorize?oauth_token=' . $oauth_tokens['oauth_token'];
  $authorize .= '&oauth_callback=' . urlencode($request->getSchemeAndHttpHost() . '/auth');
  return $app->redirect($app['session']->get('domain') . $authorize);
});

$app->get('/auth', function() use ($app) {
  $app['session']->start();
  // check if the user is already logged-in or we're already auth
  if ((null !== $app['session']->get('username')) || (null !== $app['session']->get('auth_secret'))) {
    return $app->redirect('/');
  }

  $oauth_token = $app['session']->get('access_token');
  $secret = $app['session']->get('access_secret');
  if ($oauth_token == null) {
    $app->abort(400, 'Invalid token');
  }
  $client = new Client($app['session']->get('domain') . '/oauth', array(
    'curl.CURLOPT_SSL_VERIFYPEER' => TRUE,
    'curl.CURLOPT_CAINFO' => 'assets/mozilla.pem',
    'curl.CURLOPT_FOLLOWLOCATION' => FALSE,
  ));

  $oauth = new OauthPlugin(array(
    'consumer_key' => $app['session']->get('consumer_key'),
    'consumer_secret' => $app['session']->get('consumer_secret'),
    'token' => $oauth_token,
    'token_secret' => $secret,
  ));
  $client->addSubscriber($oauth);

  $response = $client->get('access_token')->send();

  // Parse oauth tokens from response object
  $oauth_tokens = array();
  parse_str($response->getBody(TRUE), $oauth_tokens);
  $app['session']->set('auth_token', $oauth_tokens['oauth_token']);
  $app['session']->set('auth_secret', $oauth_tokens['oauth_token_secret']);
  return $app->redirect('/');
});

$app->run();
