<?php
/**
 * custom_inc.php stores custom functions specific to your application
 * 
 * Keeping common_inc.php clear of your functions allows you to upgrade without conflict
 * 
 * @package nmCommon
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.091 2011/06/17
 * @link http://www.newmanix.com/  
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @todo add safeEmail to common_inc.php
 */
 
/**
 * Place your custom functions below so you can upgrade common_inc.php without trashing 
 * your custom functions.
 *
 * An example function is commented out below as a documentation example  
 *
 * View common_inc.php for many more examples of documentation and starting 
 * points for building your own functions!
 */ 

/**
 * Checks data for alphanumeric characters using PHP regular expression.  
 *
 * Returns true if matches pattern.  Returns false if it doesn't.   
 * It's advised not to trust any user data that fails this test.
 *
 * @param string $str data as entered by user
 * @return boolean returns true if matches pattern.
 * @todo none
 */

/* 
function onlyAlphaEXAMPLE($myString)
{
  if(preg_match("/[^a-zA-Z]/",$myString))
  {return false;}else{return true;} //opposite logic from email?  
}#end onlyAlpha() 



function showFeeds()
{
    startSession();
    // begin sql call to process rss feed
    $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
    $sql = "select Description from wn18_RSS_Feeds where FeedID=" . $myID;
    # connection comes first in mysqli (improved) function
    $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

    if(!isset($_SESSION['Feeds'])){$_SESSION['Feeds'] = array();
                                  
    while($row = mysqli_fetch_assoc($result)){# process SQL

        // pulls the RSS feed link if not cached
        $request = dbOut($row['Description']);

        $TimeDate = date("Y-m-d H:i:s"); 
        
        //populate the object array with a new instance of Feed class
        $_SESSION['Feeds'][] = new Feed($myID, $request, $TimeDate);     

        
        //dumpDie($_SESSION['Feeds']);
        //^currently returns an array of objects 
        } 
    mysqli_free_result($result);// end sql call
                                   
    }else if(isset($_SESSION['Feeds'])){
        
        foreach($_SESSION['Feeds'] as $Feed){
            //foreach processes the array of Feed objects and if the FeedID matches the ID stored in a session
            // displays the XML from the SESSION cache not db 
            $FeedID = $Feed->myID;
            $TimeStamp = $Feed->TimeDate;
            
                if ($FeedID == $myID){
                $request = $Feed->Description;
                }//end if IDs match
                else {
                    while($row = mysqli_fetch_assoc($result)){# process SQL

                        // pulls the RSS feed link if not cached
                        $request = dbOut($row['Description']);
                        $TimeDate = date("Y-m-d H:i:s");

                        //populate the object array with a new instance of Feed class
                        $_SESSION['Feeds'][] = new Feed($myID, $request, $TimeDate);     


                    }//end while db loop 
                     mysqli_free_result($result);// end sql call
                }//end else            
            }//end foreach
        }//end elseif isset
    
// takes the contents of the xml file and loads them
$response = file_get_contents($request);
$xml = simplexml_load_string($response);    
// display the title of the channel
print '<h1>' . $xml->channel->title . '</h1>';

// process through the array of stories and display link+title+description
foreach($xml->channel->item as $story)
  {
    echo '<h3>' . $story->title . '</h3>
    <p>' . $story->pubDate . '<br />
    <img src="' . $story->image . '">' . $story->description . '</p>';
  }  
    
}//end showFeeds()

class Feed
{
    public $myID = 0;
    public $Description = '';
    public $TimeDate = '';
    
    public function __construct($myID, $Description, $TimeDate)
    {
        $this->myID = $myID;
        $this->Description = $Description;
        $this->TimeDate = $TimeDate;
        
    }//end Feed constructor
}//end feed class