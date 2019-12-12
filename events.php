<?php 

/**
 *
 * @author 		Sp3ciaL2X <Sp3ciaL2X@gmail.com>
 * @since 		2019
 * @license 		We live in a free world
 * @copyright 		By Sp3ciaL2X
 * @version 		1.0.0
 *
 **/

namespace Events;

interface EventsInterface {

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Events::registerEvent
	 * @param 		[ String ]		$eventName 	= Event Name
	 * @param 		[ Callable ]	$callback 	= Function to be add
	 * @param 		[ Integer ]		$eventOrder = Event Order
	 * @return 		[ Boolean ]
	 * @example 		Events::registerEvent( "join" , [ $class , "welcome" ] , 1 )
	 * @example 		Events::registerEvent( "join" , "welcome" , 1 )
	 *
	 * Creates an event in the specified order
	 *
	 */

	public function registerEvent( string $eventName , callable $callback , int $eventOrder = NULL ) : bool;

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Events::unregisterEvent
	 * @param 		[ String ] 	 $eventName = Event Name
	 * @param 		[ Callable ] $callback 	= Function to be add
	 * @return 		[ Boolean ]
	 * @example 		Events::unregisterEvent( "join" , [ $class , "welcome" ] )
	 *
	 * Deletes the specified function in the event ,
	 * will delete the event completely if there is no function left in the event of deletion
	 *
	 */

	public function unregisterEvent( string $eventName , callable $callback ) : bool;

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Events::triggerEvent
	 * @param 		[ String ]	$eventName 	= Event Name
	 * @param 		[ Array ] 	$parameters = Parameter for the function to be executed
	 * @return 		[ Boolean ]
	 * @example 		Events::triggerEvent( "join" , [ "value_1" , "value_2" ] )
	 *
	 * Executes all functions in the specified event
	 *
	 */

	public function triggerEvent( string $eventName , array $parameters = array() ) : bool;

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Events::getEvents
	 * @param 		[ Void ]
	 * @return 		[ Array ]
	 * @example 		Events::getEvents( void )
	 *
	 * Return All events
	 *
	 */

	public function getEvents() : array;

}

final class Events implements EventsInterface {

	private $registered	= NULL;

	final public function registerEvent( string $eventName , callable $callback , int $eventOrder = NULL ) : bool {

		if ( isset( $this->registered[ $eventName ] ) && is_array( $this->registered[ $eventName ] ) && array_key_exists( $eventOrder , $this->registered[ $eventName ] ) ) {
			
			if ( is_array( $this->registered[$eventName][$eventOrder] ) ) {
				
				$className	= get_class( $this->registered[$eventName][$eventOrder][ "0" ] );
				$function	= $this->registered[$eventName][$eventOrder][ "1" ];
				 

				echo "There are '{$className}::{$function}' event in the specified order";

			}else{

				echo "There are '{$this->registered[$eventName][$eventOrder]}' event in the specified order";

			}

			return False;

		}

		if ( is_null( $eventOrder ) != False ) {
			
			$this->registered[ strtolower( $eventName ) ][] = $callback;

		}

		if ( is_null( $eventOrder ) != True ) {
			
			$this->registered[ strtolower( $eventName ) ][ $eventOrder ] = $callback;

		}

		return True;
		
	}

	final public function unregisterEvent( string $eventName , callable $callback ) : bool {

		if ( is_array( $this->registered ) != True ) return False;

		if ( in_array( $callback , $this->registered[ $eventName ] ) != True ) return False;

		/*if ( in_array( $callback , $this->registered[ $eventName ] ) != False ) {
			
			unset( $this->registered[ $eventName ][ array_search( $callback , $this->registered[ $eventName ] ) ] );

		}

		if ( empty( $this->registered[ $eventName ] ) ) {
			
			unset( $this->registered[ $eventName ] );

		}*/

		foreach ( $this->registered[ $eventName ] as $key => $value ) {
			
			if ( $callback == $value ) {
				
				unset( $this->registered[ $eventName ][ $key ] );

			}

			if ( empty( $this->registered[ $eventName ] ) ) {
				
				unset( $this->registered[ $eventName ] );

			}					

		}

		return True;

	}

	final public function triggerEvent( string $eventName , array $parameters = array() ) : bool {

		if ( is_array( $this->registered ) != True ) return False;

		if ( array_key_exists( $eventName , $this->registered ) != True ) {
			
			echo "The specified '{$eventName}' event not found";

			return False;

		}

		foreach ( $this->registered[ $eventName ] as $value ) {
			
			call_user_func_array( $value , $parameters );

		}

		return True;

	}

	final public function getEvents() : array {

		return ( array ) $this->registered;

	}

}

?>
