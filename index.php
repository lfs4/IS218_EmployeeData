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
class user{
	public $name;
	public $email;
	public $pasword;
	function save(){
		
	}
}
class users{
	public $users;
	//function add(username, password,email){}
	function delete(){}
	function authenticate(){}
}
class file{
	public $file_name = 'test.csv';
	protected function read_csv(){
		$first_num = TRUE;
		if(($handle = fopen($$this->filename,"r" )) !== FALSE){
			while(($data = fgetcsv($handle,0,'','')) !== FALSE){
				if($first_num = TRUE){
					$field_names = $this->create_field_names($data);
					$first_num = FALSE;	
				}
				else {
					$records[] = $this->create_record($data,$field_names);
				}
			}
			fclose($handle);
		}
	}
	public function create_field_names($data)
	{
		return $data;
	}
	public function create_record($data, $field_names){
		$data = array_combine($field_names, $data);
		return $data;
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
        $menu .= '<br><a href="./index.php?page=login">Login</a> ';
		$menu .= '<br><a href="./index.php?page=register">Register</a> ';
		$menu .= '<br><a href="./index.php?page=forgotPW">Forgot Password</a> ';
		$menu .= '<br><a href="./index.php?page=transactionsTable">Transactions Table</a> ';
		$menu .= '<br><a href="./index.php?page=makePayment">Debit/Credit Transactions</a> ';
		
        return $menu;
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
		$session = new session();
		$this->content .=$this->menu();
		if($_SESSION['loggedIn'] ==  TRUE){
			$this->content.= '<br>Hi ' . $_SESSION['username'] . ' ,';
		}
		$this->content .=$this->makeTable();
		
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
			
			header('Location: ./index.php?page=transactionsTable');
			
			
		}else{
			header('Location: ./index.php?page=incorrectLogin');	
		} 
	}
}
?>