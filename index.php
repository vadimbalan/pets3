<?php

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start a session
session_start();

// Require the autoload file
require_once("vendor/autoload.php");

// Instantiate the F3 Base Class
$f3 = Base::instance();

//set color
$f3->set('colors', array('pink', 'green', 'blue'));
/////
// Default route
$f3->route('GET /', function()
{
    //echo '<h1>My Pets</h1>';
    $view = new Template();
    echo $view->render('views/pet-home.html');
});

// Default route
$f3->route('GET|POST /order', function($f3)
{
    // Check if the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        var_dump($_POST);
        // Validate the data
        if (empty($_POST['pet']))
        {
            echo "Please supply a pet type";
        }
        else
        {
            $_SESSION['pet'] = $_POST['pet'];
            $_SESSION['color'] = $_POST['color'];

            $f3->reroute("summary");
            session_destroy();
        }
    }

    //echo '<h1>Test</h1>';
    $view = new Template();
    echo $view->render('views/pet-order.html');
});

$f3->route('GET /summary', function()
{
    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run F3
$f3->run();

