<?php
/**
 * demo_sesion_cache.php is a single page web application that allows us to request and view 
 * a customer's name
 *
 * This version uses no HTML directly so we can code collapse more efficiently
 *
 * This page is a model on which to demonstrate fundamentals of single page, postback 
 * web applications.
 *
 * Any number of additional steps or processes can be added by adding keywords to the switch 
 * statement and identifying a hidden form field in the previous step's form:
 *
 *<code>
 * <input type="hidden" name="act" value="next" />
 *</code>
 * 
 * The above live of code shows the parameter "act" being loaded with the value "next" which would be the 
 * unique identifier for the next step of a multi-step process
 *
 * @package ITC250
 * @author Brian Wise <briandwise7@gmail.com>
 * @version 1.0 2018/03/01
 * @link http://www.brianwise.xyz/wn18
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @todo finish instruction sheet
 * @todo add more complicated checkbox & radio button examples
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

/*
$ducks[] = new Duck('Huey', 'Fishing', 1.5);
$ducks[] = new Duck('Dewey', 'Camping', .75);
$ducks[] = new Duck('Louie', 'Flying', .25);

foreach($ducks as $duck)
{
    echo '<p>' . $duck . '</p>';
}
die;
*/

//END CONFIG AREA ----------------------------------------------------------

# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}

switch ($myAction) 
{//check 'act' for type of process
	case "display": # 2)Display user's name!
	 	showDucks();
	 	break;
	default: # 1)Ask user to enter their name 
	 	duckForm();
}

function duckForm()
{# shows form so user can enter their name.  Initial scenario
	get_header(); #defaults to header_inc.php	
	
	echo 
	'<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	<script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			if(empty(thisForm.Name,"Please Enter Duck Name")){return false;}
			if(empty(thisForm.Hobby,"Please Enter Duck Hobby")){return false;}
			if(empty(thisForm.Allowance,"Please Enter Duck Allowance")){return false;}
			return true;//if all is passed, submit!
		}
	</script>
	<h3 align="center">' . smartTitle() . '</h3>
	<p align="center">Create a Duck</p> 
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
		<table align="center">
			<tr>
				<td align="right">
					Name
				</td>
				<td>
					<input type="text" name="Name" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
				</td>
			</tr>
            <tr>
            <td align="right">
                Hobby
            </td>
				<td>
					<input type="text" name="Hobby" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
				</td>
			</tr>
            <tr>
				<td align="right">
					Allowance
				</td>
				<td>
					<input type="text" name="Allowance" /><font color="red"><b>*</b></font> <em>(numeric only)</em>
				</td>
			</tr>
            
			<tr>
				<td align="center" colspan="2">
					<input type="submit" value="Get Quackin"><em>(<font color="red"><b>*</b> required field</font>)</em>
				</td>
			</tr>
		</table>
		<input type="hidden" name="act" value="display" />
	</form>
	';
	get_footer(); #defaults to footer_inc.php
}

function showDucks()
{#form submits here we show entered name
	get_header(); #defaults to footer_inc.php
    
    //dumpDie($_POST);
    startSession();
    
    if(!isset($_SESSION['Ducks']))
    {
        $_SESSION['Ducks'] = array();
    }
    //$ducks[] = new Duck('Huey', 'Fishing', 1.5);
    //no checks- verify data in the fields 
    $_SESSION['Ducks'][] = new Duck($_POST['Name'], $_POST['Hobby'], (float)$_POST['Allowance']);
    
    dumpDie($_SESSION['Ducks']);
    
    
	if(!isset($_POST['Name']) || $_POST['Name'] == '')
	{//data must be sent	
		feedback("No form data submitted"); #will feedback to submitting page via session variable
		myRedirect(THIS_PAGE);
	}  
	
	if(!ctype_alnum($_POST['Name']))
	{//data must be alphanumeric only	
		feedback("Only letters and numbers are allowed.  Please re-enter your name."); #will feedback to submitting page via session variable
		myRedirect(THIS_PAGE);
	}
	
	$myName = strip_tags($_POST['YourName']);# here's where we can strip out unwanted data
	
	echo '<h3 align="center">' . smartTitle() . '</h3>';
	echo '<p align="center">Your duck name is <b>' . $myName . '</b>!</p>';
	echo '<p align="center"><a href="' . THIS_PAGE . '">RESET</a></p>';
	get_footer(); #defaults to footer_inc.php
}

class Feed
{
    public $Name = '';
    public $Description = '';
    public $Allowance = 0;
    
    public function __construct($Name, $Hobby, $Allowance)
    {
        $this->Name = $Name;
        $this->Hobby = $Hobby;
        $this->Allowance = $Allowance;
        
    }//end Feed constructor

    public function __toString()
    {
        setlocale(LC_MONETARY, 'en_US');
        $Allowance = money_format('%i', $this->Allowance);

        $myReturn = '';
        $myReturn .= 'Name: ' . $this->Name . ' ';
        $myReturn .= 'Hobby: ' . $this->Hobby . ' ';
        $myReturn .= 'Allowance: ' . $Allowance . ' ';

        return $myReturn;

    }//end toString function

}//end feed class














