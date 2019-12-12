<?php 

require 'events.php';

class details {

	function getEmail( $username , $uid ) {

		echo "username:{$username} , uid:{$uid} john@doe.com";

	}

}

function welcome( string $username ) {

	echo "Welcome Back {$username}";

}

$event = new Events\Events;

$event->registerEvent( "login" , "welcome" , 1 );
$event->registerEvent( "login" , [ new details , "getEmail" ] , 2 );

$event->triggerEvent( "login" , [ "Sp3ciaL2x" , 1 ] );

print_r( $event->getEvents() );

?>