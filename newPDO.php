<?php


//print_r(PDO::getAvailableDrivers());  

$host = 'sql.njit.edu';
$dbname = 'lfs4';
$user = 'lfs4';
$pass = '1MVQE1Y6';

try{
	
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	//echo 'connected to database';
	$STH = $DBH->query('SELECT hd2011.INSTNAME, effy2011.EFFYTOTLT,
						effy2010.ENTOT,
						FROM hd2011
						INNER JOIN effy2011 on 
						hd2011.UNITID = effy2011.UNITID
						INNER JOIN effy2010 on
						hd2011.UNITID = effy2010.UNITID
						ORDER BY effy2011.EFFYTOTLT
						DESC
						LIMIT 10;');
	//$STH->execute();
	
	//$STH = $DBH->query('SELECT first_name, last_name from employees')
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	//print_r($STH->fetch());
	echo '<table border = "1">';
	echo '<tr>';
	echo '<td>University</td>';
	echo '<td>Enrollment 2011</td>';
	echo '<td>Enrollment 2010</td>';
	echo '</tr>';
	$first = TRUE;
	while($row = $STH->fetch()){
		echo '<tr>';
		echo '<td>' . $row['INSTNAME'] . ' </td>';
		echo '<td>' . $row['EFFYTOTLT'] . ' </td>';
		echo '<td>' . $row['ENTOT'] . '</td>';
		echo '</tr>';
			//$first = FALSE;
	//	}
		//echo $row->name;
		/*echo '<tr>';
		echo '<td>' . $row['UNITID'] . ' </td>';
		echo '<td>' . $row['INSTNAME'] . '</td>';
		echo '</tr>';
		*/
		
	}
	
	echo '</table>';
}


catch(PDOException $e){
	echo $e->getMessage();
}

?>