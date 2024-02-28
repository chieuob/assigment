<?php
if ( !isset( $_SESSION ) )session_start();
$host = 'localhost';
$username = 'concertApp';
$password = 'evc9evc9!';
$database = 'discord';
date_default_timezone_set( "America/Los_Angeles" );
$tim = strtotime( date( "m/d H:i", time() ) );
$sql = mysqli_connect( $host, $username, $password, $database );
if ( !$sql ) {
     die ("mysqli_error");
}

// Database Crea/Read/Update/Delete functions:

/* create('tableName','key, is separate by comma',"'values','separated by comma'"); if table has index it'll return index number. */
function create( $table, $key, $val=null) {
     global $sql;
	if(is_array($key)){
		$keys=implode(',',array_keys($key));
		$value="'".implode("','",array_values($key))."'";
	}else{$keys=$key;$value=$val;}
     $sqlcomand = sprintf( "INSERT INTO %s (%s) VALUES (%s);", $table, $keys, $value );
	//echo $sqlcomand;
     execute( $sqlcomand );
     return mysqli_insert_id( $sql );
}

/* read('tableName','*', or articles separate by comma',"columnName='valiable'"); it'll return an array. */
function read( $table, $article, $condition = null ) {
     $comand = "SELECT $article FROM $table";
     if ( $condition == null ) {
          $comand .= ";";
     } else {
          $comand .= " $condition;";
     }
	//echo $comand;
     $result = execute( $comand );
     while ( $read = mysqli_fetch_assoc( $result ) ) {
          $readed[] = $read;
     }
     if ( isset( $readed ) ) return $readed;
     return false;
}

/* update('tableName','$key,separate by comma or an array',"'value','separated by comma or an array'","columnName='valiable'");*/
function update( $table, $key=null, $val=null, $condition=null ) {
	if(is_array($key) and is_array($key)){
		$key=implode(",",array_keys($key));
		$val="'".implode("','",array_values($val))."'";
	}
     $ky = explode( ',', $key );
     $vl = explode( ",", $val );
     $comand = "UPDATE $table SET ";
     for ( $i = 0; $i < count( $ky ) - 1; $i++ ) {
          $comand .= "$ky[$i] = $vl[$i],";
     }
     $comand .= "$ky[$i] = $vl[$i] WHERE $condition;";
	//echo $comand;
     execute( $comand );
}

/* delete('tableName',"columnName='valiable'"); */
function delete( $table, $condition ) {
     $comand = "DELETE FROM $table WHERE $condition;";
	//echo $comand;
     execute( $comand );
}

function execute( $comand ) {
     global $sql;
     return $sql->query( $comand );
}

?>
