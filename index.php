<?php
$program = new program();
class program
{
    function __construct()
    {
        $page = 'homepage';
        $arg  = NULL;
        if (isset($_REQUEST['page'])) {
            $page = $_REQUEST['page'];
        }
        if (isset($_REQUEST['arg'])) {
            $arg = $_REQUEST['arg'];
        }
        
        //echo $page;
        $page = new $page($arg);
}			
    function __destruct()
    {
    }
}
class session{
	public function __construct(){
		session_start();
	}
	public function saveUser($username, $password){
		$_SESSION['username'] =  $username;
		$_SESSION['password'] = $password;
		$_SESSION['loggedIn'] =  true;
	}


}
abstract class page
{
    public $content;
    protected $host = 'sql.njit.edu';
    protected $dbname = 'lfs4';
    protected $user = 'lfs4';
    protected $pass = '1MVQE1Y6';
    
    protected $newQuery = '';
    
    protected $table = '';
    
    protected function menu()
    {
        $menu = '<a href="./index.php">Homepage</a> ';
        $menu .= '<a href="./index.php?page=login">Login</a> ';
		
        return $menu;
    }
    
    function __construct($arg = NULL)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->get();
        } else {
            $this->post();
        }
    }
    function get()
    {
        $this->content .= $this->menu();
	$this->content .= $this->makeTable();
    }
    function post()
    {
    	print_r($_POST);
    }
    function __destruct()
    {
        
        echo $this->content;
    }
    
}
class homepage extends page
{
	protected function menu()
	{
		$menu = '<h1>Homepage</h1>';
		$menu .= '<br><a href="./index.php?page=totalEn">1. Total Enrollment</a> ';
		$menu .= '<br><a href="./index.php?page=totalLib">2. Total Liabilities</a> ';
		$menu .= '<br><a href="./index.php?page=totalAssets">3. Total Assets</a> ';
		$menu .= '<br><a href="./index.php?page=totalRev">5. Total Revenue</a> ';
		$menu .= '<br><a href="./index.php?page=assetsPerStudent">6. Assets Per Student</a> ';
		$menu .= '<br><a href="./index.php?page=libPerStudent">7. Liabilities Per Student</a> ';
		$menu .= '<br><a href="./index.php?page=revPerStudent">8. Revenue Per Student</a> ';
		$menu .= '<br><a href="./index.php?page=stateForm">10. Select College From State</a> ';
		
		
        return $menu;
	}
	
	protected function makeTable()
	{
	    
	}
}
class totalEn extends page
{

    
    function get()
    {
	$this->content .= $this->menu();
	$this->content .= $this->makeTable();
    }
    function makeTable()
    {
	   $this->newQuery .=  'SELECT hd2011.INSTNAME, effy2011.EFFYTOTLT, effy2010.ENTOT
				    FROM hd2011
				    JOIN effy2011
				    ON
				    hd2011.UNITID = effy2011.UNITID
				    JOIN effy2010
				    ON
				    hd2011.UNITID = effy2010.UNITID
				    ORDER BY effy2011.EFFYTOTLT
				    DESC
				    LIMIT 10';
    

	
	try{
	
	    $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	    //echo 'connected to database';
	    $STH = $DBH->query($this->newQuery);
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $this->table .= '<table border = "1">';
	    $this->table .= '<tr>';
	    $this->table .= '<td>University</td>';
	    $this->table .= '<td>Total Enrollment 2011</td>';
	    $this->table .= '<td>Total Enrollment 2010</td>';
	    $this->table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $this->table .= '<tr>';
		    $this->table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $this->table .= '<td>' . $row['EFFYTOTLT'] . '</td>';
		    $this->table .= '<td>' . $row['ENTOT'] . '</td>';
		    $this->table .= '</tr>';
		    
	    }
	    
	    $this->table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $this->table;
    }
}
class totalLib extends page
{
    function makeTable()
    {
	   $this->newQuery .=  'SELECT hd2011.INSTNAME,financial2011.TOTLIB AS LIB11,
				financial2010.TOTLIB AS LIB10
				FROM hd2011
				INNER JOIN financial2011 on
				hd2011.UNITID = financial2011.UNITID
				INNER JOIN financial2010 on
				hd2011.UNITID = financial2010.UNITID
				ORDER BY financial2011.TOTLIB
				DESC
				LIMIT 10';
				    

	
	try{
	
	    $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	    //echo 'connected to database';
	    $STH = $DBH->query($this->newQuery);
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $this->table .= '<table border = "1">';
	    $this->table .= '<tr>';
	    $this->table .= '<td>University</td>';
	    $this->table .= '<td>Total Liabilities 2011</td>';
	    $this->table .= '<td>Total Liabilities 2010</td>';
	    $this->table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $this->table .= '<tr>';
		    $this->table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $this->table .= '<td>' . $row['LIB11'] . '</td>';
		    $this->table .= '<td>' . $row['LIB10'] . '</td>';
		    $this->table .= '</tr>';
		    
	    }
	    
	    $this->table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $this->table;
    }
}
class totalAssets extends page
{

    function makeTable()
    {
	   $this->newQuery .=  'SELECT hd2011.INSTNAME, financial2011.TOTNASSETS AS TOTASSETS11,
				financial2010.TOTNASSETS AS TOTASSETS10
				FROM hd2011
				INNER JOIN financial2011 on
				hd2011.UNITID = financial2011.UNITID
				INNER JOIN financial2010 on
				hd2011.UNITID = financial2010.UNITID
				ORDER BY financial2011.TOTNASSETS
				DESC
				LIMIT 10';
				    

	
	try{
	
	    $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	    //echo 'connected to database';
	    $STH = $DBH->query($this->newQuery);
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $this->table .= '<table border = "1">';
	    $this->table .= '<tr>';
	    $this->table .= '<td>University</td>';
	    $this->table .= '<td>Total Assets 2011</td>';
	    $this->table .= '<td>Total Assets 2010</td>';
	    $this->table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $this->table .= '<tr>';
		    $this->table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $this->table .= '<td>' . $row['TOTASSETS11'] . '</td>';
		    $this->table .= '<td>' . $row['TOTASSETS10'] . '</td>';
		    $this->table .= '</tr>';
		    
	    }
	    
	    $this->table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $this->table;
    }
}
class totalRev extends page
{
     function makeTable()
    {
	   $this->newQuery .=  ' SELECT hd2011.INSTNAME, financial2011.TOTREV AS TOTREV11,
				    financial2010.TOTREV AS TOTREV10
				    FROM hd2011
				    INNER JOIN financial2011 on
				    hd2011.UNITID = financial2011.UNITID
				    INNER JOIN financial2010 on
				    hd2011.UNITID = financial2010.UNITID
				    ORDER BY financial2011.TOTREV
				    DESC
				    LIMIT 10';
									

	
	try{
	
	    $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	    //echo 'connected to database';
	    $STH = $DBH->query($this->newQuery);
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $this->table .= '<table border = "1">';
	    $this->table .= '<tr>';
	    $this->table .= '<td>University</td>';
	    $this->table .= '<td>Total Revenue 2011</td>';
	    $this->table .= '<td>Total Revenue 2010</td>';
	    $this->table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $this->table .= '<tr>';
		    $this->table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $this->table .= '<td>' . $row['TOTREV11'] . '</td>';
		    $this->table .= '<td>' . $row['TOTREV10'] . '</td>';
		    $this->table .= '</tr>';
		    
	    }
	    
	    $this->table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $this->table;
    }
}
class assetsPerStudent extends page
{
    function makeTable()
    {
	   $this->newQuery .=  ' SELECT hd2011.INSTNAME, financial2011.TOTNASSETS/effy2011.EFFYTOTLT AS AssetsPerStudent11,
				    financial2010.TOTNASSETS/effy2010.ENTOT AS AssetsPerStudent10
				    FROM hd2011
				    INNER JOIN effy2010
				    ON
				    hd2011.UNITID = effy2010.UNITID
				    INNER JOIN effy2011
				    ON
				    hd2011.UNITID = effy2011.UNITID
				    INNER JOIN financial2010 on
				    hd2011.UNITID = financial2010.UNITID
				    INNER JOIN financial2011
				    ON
				    hd2011.UNITID = financial2011.UNITID
				    ORDER BY AssetsPerStudent11
				    DESC
				    LIMIT 10';
									

	
	try{
	
	    $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	    //echo 'connected to database';
	    $STH = $DBH->query($this->newQuery);
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $this->table .= '<table border = "1">';
	    $this->table .= '<tr>';
	    $this->table .= '<td>University</td>';
	    $this->table .= '<td>Total Assets Per Student 2011</td>';
	    $this->table .= '<td>Total Assets Per Student 2010</td>';
	    $this->table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $this->table .= '<tr>';
		    $this->table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $this->table .= '<td>' . $row['AssetsPerStudent11'] . '</td>';
		    $this->table .= '<td>' . $row['AssetsPerStudent10'] . '</td>';
		    $this->table .= '</tr>';
		    
	    }
	    
	    $this->table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $this->table;
    }
}
class libPerStudent extends page
{
     function makeTable()
    {
	   $this->newQuery .=  ' SELECT hd2011.INSTNAME, financial2011.TOTLIB/effy2011.EFFYTOTLT AS LibPerStudent11,
				    financial2010.TOTLIB/effy2010.ENTOT AS LibPerStudent10
				    FROM hd2011
				    INNER JOIN effy2010
				    ON
				    hd2011.UNITID = effy2010.UNITID
				    INNER JOIN effy2011
				    ON
				    hd2011.UNITID = effy2011.UNITID
				    INNER JOIN financial2010 on
				    hd2011.UNITID = financial2010.UNITID
				    INNER JOIN financial2011
				    ON
				    hd2011.UNITID = financial2011.UNITID
				    ORDER BY LibPerStudent11
				    DESC
				    LIMIT 10';
									

	
	try{
	
	    $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	    //echo 'connected to database';
	    $STH = $DBH->query($this->newQuery);
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $this->table .= '<table border = "1">';
	    $this->table .= '<tr>';
	    $this->table .= '<td>University</td>';
	    $this->table .= '<td>Total Assets Per Student 2011</td>';
	    $this->table .= '<td>Total Assets Per Student 2010</td>';
	    $this->table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $this->table .= '<tr>';
		    $this->table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $this->table .= '<td>' . $row['LibPerStudent11'] . '</td>';
		    $this->table .= '<td>' . $row['LibPerStudent10'] . '</td>';
		    $this->table .= '</tr>';
		    
	    }
	    
	    $this->table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $this->table;
    }
}
class revPerStudent extends page
{
     function makeTable()
    {
	   $this->newQuery .=  ' SELECT hd2011.INSTNAME, financial2011.TOTREV/effy2011.EFFYTOTLT AS RevPerStudent11,
				    financial2010.TOTREV/effy2010.ENTOT AS RevPerStudent10
				    FROM hd2011
				    INNER JOIN effy2010
				    ON
				    hd2011.UNITID = effy2010.UNITID
				    INNER JOIN effy2011
				    ON
				    hd2011.UNITID = effy2011.UNITID
				    INNER JOIN financial2010 on
				    hd2011.UNITID = financial2010.UNITID
				    INNER JOIN financial2011
				    ON
				    hd2011.UNITID = financial2011.UNITID
				    ORDER BY RevPerStudent11
				    DESC
				    LIMIT 10';
									

	
	try{
	
	    $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
	    //echo 'connected to database';
	    $STH = $DBH->query($this->newQuery);
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $this->table .= '<table border = "1">';
	    $this->table .= '<tr>';
	    $this->table .= '<td>University</td>';
	    $this->table .= '<td>Total Revenue Per Student 2011</td>';
	    $this->table .= '<td>Total Revenue Per Student 2010</td>';
	    $this->table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $this->table .= '<tr>';
		    $this->table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $this->table .= '<td>' . $row['RevPerStudent11'] . '</td>';
		    $this->table .= '<td>' . $row['RevPerStudent10'] . '</td>';
		    $this->table .= '</tr>';
		    
	    }
	    
	    $this->table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $this->table;
    }
}
class stateForm extends page
{
    function get()
    {
	$this->content .= $this->menu();
	$this->content .= $this->createForm();
    }
    function createForm(){
	$form = '<form action="index.php?page=stateTable" method="post">
		<h1>Select a State</h1>
		<p>
		    <input type = "text" name = "stateId"><br>
		    <input type = "submit">
		    
		</p>  
		';
	return $form;
    }
}

class register extends page
{
	function get()
	{
		$this->content .=$this->menu();
		$this->content .=$this->registerForm();
	}
	function registerForm()
	{
		$form = '<form action="index.php?page=register" method="post">
					<h1>Register</h1>
				    <P>
				    <LABEL for="username">Username: </LABEL>
				              <INPUT type="text" name="username" id="username"><BR>
				    <LABEL for="password">Password: </LABEL>
				              <INPUT type="text" name ="password" id="password"><BR>
				     <LABEL for="re_password">ReEnter Password: </LABEL>
				              <INPUT type="text" name ="re_password" id="re_password"><BR>
				     <label for="email">Email Address:</label>
				     		  <INPUT type="text" name="email" id="email"><br>
				    <INPUT type="submit" value="Send"> <INPUT type="reset">
				    </P>
				</form>';
				return $form;
	}
	

}
class makePayment extends page
{
	function get()
	{
		$this->content .=$this->menu();
		$this->content .=$this->makeForm();
	}
	function makeForm()
	{
		$form ='<form action="index.php?page=makePayment" method="post">
				    <h1>Make a Payment</h1>
				    <P>
				    <LABEL for="amount">Amount: </LABEL>
				              <INPUT type="text" name="amount" id="amount"><BR>
				    <LABEL for="card_num">Card Number: </LABEL>
				              <INPUT type="text" name ="card_num" id="card_num"><BR>
				     <LABEL for="exp_date">Experation Date: </LABEL>
				              <INPUT type="text" name ="exp_date" id="exp_date"><BR>
				     <label for="sec_code">Security Code</label>
				     		  <INPUT type="text" name="sec_code" id="sec_code"><br>
				     <label for="transacton_type">Transaction Type</label>
				     		  <select name="transaction_type">
				     		  <option value="debit">Debit</option>
				     		  <option value="credit">Credit</option>
				     		  <br>
				     		  </select>
				     		  <br>
				    <INPUT type="submit" value="Send"> <INPUT type="reset">
				    </P>
				</form>';
				return $form;
	}
}
class transactionsTable extends page
{
	function get()
	{
	
		$this->content .=$this->menu();
		
		/*(if($_SESSION['loggedIn'] == true)
		{
			$this->content .= $this->greeting();
		}*/
		
		$this->content .=$this->makeTable();
		
		echo $_SESSION['username'];
	}
	function greeting()
	{
	}
	function makeTable()
	{
		$table = '<h1>Transaction History</h1>
					<table border = \"1\">
					<tr>
					<th>Date</th>
					<th>Transaction Source</th>
					<th>Transaction Type</th>
					<th>Transaction Amount</th>
					</tr>
					<tr>
					<td>10/2/13</td>
					<td>Amazon</td>
					<td>Debit</td>
					<td>$50</td>
					</tr>
				  </table>';
		return $table;
	}
}
class forgotPW extends page
{
	function get()
	{
		$this->content .=$this->menu();
		$this->content .=$this->forgotPWForm();
	}
	function forgotPWForm()
	{
		$form = '<form action="index.php?page=register" method="post">
					<h1>Forgot Password?</h1>
				    <P>
				    <LABEL for="username">Username: </LABEL>
				              <INPUT type="text" name="username" id="username"><BR>
				    <LABEL for="email">Email Address: </LABEL>
				              <INPUT type="text" name ="email" id="email"><BR>
				     <INPUT type="submit" value="Send"> <INPUT type="reset">
				    </P>
				</form>';
				return $form;
	}
}
class incorrectLogin extends page
{
	function get(){
		$this->content .=$this->errorMessage();
	}
	function errorMessage()
	{
		$errMessage = 'Your credentials are incorrect, please try to login again' . '<br>';
		$errMessage .= '<a href="./index.php?page=login">Login</a>';
		return $errMessage;
	}
}
class login extends page
{
    function get()
    {
    	$this->content .=$this->menu();
        $this->content .= $this->loginForm();
    }
    function loginForm()
    {
        $form = '<form action="index.php?page=login" method="post">
        				<h1>Login</h1>
					    <P>
					    <LABEL for="username">Username: </LABEL>
					              <INPUT type="text" name="username" id="username"><BR>
					    <LABEL for="password">Password: </LABEL>
					              <INPUT type="text" name ="password" id="password"><BR>
					    <INPUT type="submit" value="Send"> <INPUT type="reset">
					    </P>
					</form>';
		$form .= '<a href="./index.php?page=register">Register</a>';
		$form .= '<br><a href="./index.php?page=forgotPw">Forgot Password?</a>';

		
        return $form;
    }
	function post()
	{
		if($_POST['username'] == 'lou' && $_POST['password'] == 123)
		{
			$session = new session();
			$session->saveUser($_POST['username'], $_POST['password']);
			
			print_r($_SESSION);
			
			header('Location: http://web.njit.edu/~lfs4/is218/index.php?page=transactionsTable');
			
			
		}else{
			header('Location: http://web.njit.edu/~lfs4/is218/index.php?page=incorrectLogin');	
		} 
	}
}
?>