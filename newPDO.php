<?php


//print_r(PDO::getAvailableDrivers());  

$host = 'sql.njit.edu';
$dbname = 'lfs4';
$user = 'lfs4';
$pass = '1MVQE1Y6';

try{
	
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	//echo 'connected to database';
	$STH = $DBH->query('SELECT * FROM hd2011 LIMIT 10');
	//$STH->execute();
	
	//$STH = $DBH->query('SELECT first_name, last_name from employees');
	
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	//print_r($STH->fetch());
	echo '<table border = "1">';
	while($row = $STH->fetch()){
		//echo $row->name;
		echo '<tr>';
		echo '<td>' . $row['UNITID'] . ' </td>';
		echo '<td>' . $row['INSTNAME'] . '</td>';
		echo '</tr>';
		
	}
	
	echo '</table>';
}


catch(PDOException $e){
	echo $e->getMessage();
}

?>