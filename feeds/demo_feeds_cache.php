<?php
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

/*
$ducks[] = new Duck('Huey', 'Fishing', 1.5);

foreach($ducks as $duck)
{
    echo '<p>' . $duck . '</p>';
}
die;
*/

# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}

switch ($myAction) 
{//check 'act' for type of process
	case "display": # 2)Display user's name!
	 	showFeeds();
	 	break;
	default: # 1)Ask user to enter their name 
	 	myRedirect(VIRTUAL_PATH . "feeds/feed_view.php");
}
dbOut($row['Description'])

function showFeeds()
{#form submits here we show entered name
	get_header(); #defaults to footer_inc.php
    
    //dumpDie($_POST);
    startSession();
    
    if(!isset($_SESSION['Feeds']))
    {
        $_SESSION['Feeds'] = array();
    }
    //$ducks[] = new Duck('Huey', 'Fishing', 1.5);
    //no checks- verify data in the fields 
    $_SESSION['Feeds'][] = new Feed($myID, $Description, $TimeDate);
    
    dumpDie($_SESSION['Feeds']);
    

}

class Feed
{
    public $myId = 0;
    public $Description = '';
    public $TimeDate = '';
    
    public function __construct($myID, $Description, $TimeDate)
    {
        $this->myID = $myID;
        $this->Description = $Description;
        $this->TimeDate = $TimeDate;
        
    }//end Feed constructor
/*
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
*/
}//end feed class














