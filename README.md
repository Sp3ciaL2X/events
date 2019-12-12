# Create And Trigger Events

> It is created to trigger your own events and the events you create with the specified values.

### Events Methods
- registerEvent( string $eventName , callable $callback , int $eventOrder = NULL )
- unregisterEvent( string $eventName , callable $callback )
- triggerEvent( string $eventName , array $parameters = array() )
- getEvents( void )

> **eventName** : String value for an event that you create

> **callback** : A valid callback function

> **eventOrder** : The order in which the event is triggered, an integer value

> **parameters** : Values to assign to triggered events

### 'registerEvent' Method

> Function used to create an event

```php
class detail {

  function getEmail( $username , $uid ) {

		echo "username:{$username} , uid:{$uid} john@doe.com";

	}

}

function welcome( string $username ) {
  
  echo "Welcome back".$username;

}

$event = new Events;

$event->registerEvent( "login" , "welcome" , 1 );
$event->registerEvent( "login" , [ new detail , "getEmail" ] , 2 );
```
> If there is already an event in the specified order, it will give an error.
```php
$event->registerEvent( "login" , "welcome" , 1 );
$event->registerEvent( "login" , [ new detail , "getEmail" ] , 1 );

# Returns "false" because the order parameter is 1 on both events
```

### 'unregisterEvent' Method

> Deletes the specified function in the event , will delete the event completely 
if there is no function left in the event of deletion

```php
$event->unregisterEvent( "login" , "welcome" );
$event->unregisterEvent( "login" , [ new detail , "getEmail" ] );

# Returns "false" if the specified event cannot be found
```

### 'triggerEvent' Method

> Trigger all added events in order

> Values should be specified as an array

```php
$event->registerEvent( "login" , "welcome" , 1 );
$event->registerEvent( "login" , [ new detail , "getEmail" ] , 2 );

$event->triggerEvent( "login" , [ "Sp3ciaL2X" , 1 ] ); 
# Welcome Back Sp3ciaL2X username:Sp3ciaL2X uid:1 john@doe.com

# Make sure it matches the event when specifying a value

$event->triggerEvent( "login" , [ 1 , "Sp3ciaL2X" ] ); # Error

# In this way, if the order of values is wrong, the result will be incorrect
```

> This function returns "false" if no events have been added or the specified event cannot be found

### 'getEvents' Method

> Returns all added events as an array

```php
$event->registerEvent( "login" , "welcome" , 1 );
$event->registerEvent( "login" , [ new detail , "getEmail" ] , 2 );

$event->registerEvent( "detail" , "welcome" , 1 );
$event->registerEvent( "detail" , [ new detail , "getEmail" ] , 2 );

print_r( $event->getEvents() );

/*
  Array(
    [ "login" ] => Array(
      [1] => "welcome",
      [2] => Array(
          [0] => Object(),
          [1] => "getEmail"
      )
    ),
    [ "detail ] => Array(
      [1] => "welcome",
      [2] => Array(
          [0] => Object(),
          [1] => "getEmail"
      )
    )
  )
*/

```
