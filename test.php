<?php

include("account.php");

try{
($dbh = mysql_connect($hostname, $username, $password))
					or die("Unable to connect to MySQL database");
		
	mysql_select_db($project);
	



/*$sql = 'SELECT hd2011.INSTNAME, effy2011.EFFYTOTLT,effy2010.ENTOT
FROM hd2011
INNER JOIN effy2011 on 
hd2011.UNITID = effy2011.UNITID
INNER JOIN effy2010 on 
hd2011.UNITID = effy2010.UNITID
ORDER BY effy2011.EFFYTOTLT
DESC
LIMIT 10;';*/


$sql = 'SELECT financial2011.TOTNASSETS, financial2010.TOTNASSETS 
FROM financial2010 
INNER JOIN financial2011 
ON
financial2010.UNITID = financial2011.UNITID
LIMIT 10;'

$query = mysql_query($sql);

$tests = mysql_fetch_assoc($query);


print_r($tests);
}
catch(PDOException $e)
{
	echo $e->getMessage();
}
/*
echo '<table border = 1>';
echo '<tr>';
echo '<th>University</th>';
echo '<th>Total Enrollment 2011</th>';
echo '<th>Total Enrollment 2010</th>';
//echo '<th>STABBR</th>';
echo '</tr>';
*/
//$rows = mysql_fetch_array($query);

/*
echo $rows['UNITID'] . '<br>';
echo $rows['INSTNAME']. '<br>';
echo $rows['STABBR'];
*/
/*
while($tableData = mysql_fetch_array($query))
{
	echo '<tr>';
	
	echo '<td>'. $tableData['INSTNAME'] .'</td>';
	echo '<td>'. $tableData['EFFYTOTLT'] .'</td>';
	echo '<td>'. $tableData['ENTOT'] .'</td>';

	//echo '<td>'. $tableData['STABBR'] .'</td>';
	echo '</tr>';


}

echo '</table>';

*/

?>