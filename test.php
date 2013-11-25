<?php

include("account.php");

($dbh = mysql_connect($hostname, $username, $password))
					or die("Unable to connect to MySQL database");
		
	mysql_select_db($project);
	



$sql = 'SELECT hd2011.INSTNAME, effy2011.EFFYTOTLT 
FROM hd2011
INNER JOIN effy2011 on 
hd2011.UNITID = effy2011.UNITID
ORDER BY effy2011.EFFYTOTLT
DESC
LIMIT 10;';


$query = mysql_query($sql);


echo '<table border = 1>';
echo '<tr>';
echo '<th>UNITID</th>';
echo '<th>INSTNM</th>';
//echo '<th>STABBR</th>';
echo '</tr>';

//$rows = mysql_fetch_array($query);

/*
echo $rows['UNITID'] . '<br>';
echo $rows['INSTNAME']. '<br>';
echo $rows['STABBR'];
*/
while($tableData = mysql_fetch_array($query))
{
	echo '<tr>';
	
	echo '<td>'. $tableData['INSTNAME'] .'</td>';
	echo '<td>'. $tableData['EFFYTOTLT'] .'</td>';
	//echo '<td>'. $tableData['STABBR'] .'</td>';
	echo '</tr>';


}

echo '</table>';



?>