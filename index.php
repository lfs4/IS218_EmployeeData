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
		$menu .= '<br><a href="./index.php?page=register">Register</a> ';
		$menu .= '<br><a href="./index.php?page=forgotPW">Forgot Password</a> ';
		$menu .= '<br><a href="./index.php?page=transactionsTable">Transactions Table</a> ';
		$menu .= '<br><a href="./index.php?page=makePayment">Debit/Credit Transactions</a> ';
		
        return $menu;
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
	$host = 'sql.njit.edu';
	$dbname = 'lfs4';
	$user = 'lfs4';
	$pass = '1MVQE1Y6';

	$table = 'Im a table!';
	try{
	
	    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	    //echo 'connected to database';
	    $STH = $DBH->query('SELECT hd2011.INSTNAME, effy2011.EFFYTOTLT, effy2010.ENTOT
				    FROM hd2011
				    JOIN effy2011
				    ON
				    hd2011.UNITID = effy2011.UNITID
				    JOIN effy2010
				    on
				    hd2011.UNITID = effy2010.UNITID
				    ORDER BY effy2011.EFFYTOTLT
				    DESC
				    LIMIT 10');
	    //$STH->execute();
	    
	    //$STH = $DBH->query('SELECT first_name, last_name from employees');
	    
	    $STH->setFetchMode(PDO::FETCH_ASSOC);
	    //print_r($STH->fetch());
	    $table = '<table border = "1">';
	    $table .= '<tr>';
	    $table .= '<td>University</td>';
	    $table .= '<td>Total Enrollment 2011</td>';
	    $table .= '<td>Total Enrollment 2010</td>';
	    $table .= '</tr>';
	    while($row = $STH->fetch()){
		    //echo $row->name;
		    $table .= '<tr>';
		    $table .= '<td>' . $row['INSTNAME'] . '</td>';
		    $table .= '<td>' . $row['EFFYTOTLT'] . '</td>';
		    $table .= '<td>' . $row['ENTOT'] . '</td>';
		    $table .= '</tr>';
		    
	    }
	    
	    $table .= '</table>';
	}


	catch(PDOException $e){
		echo $e->getMessage();
	}
	return $table;
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