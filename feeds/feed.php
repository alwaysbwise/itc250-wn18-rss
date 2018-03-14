<?
/**
 * feed.php is a page to display the sub-categories' RSS feeds
 * 
 * @package wn18/feeds
 * @author Brian Wise <briandwise7@gmail.com> Ana, Ben, Sue
 * @version 0.1 2018/02/08
 * @link http://www.brianwise.xyz/wn18
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see feed_view.php
 */
//our simplest example of consuming an RSS feed
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index feed pages

if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
    
    showFeeds();
    
}else{
	myRedirect(VIRTUAL_PATH . "feeds/feed_view.php");
}


function showFeeds()
{
    startSession();
    // begin sql call to process rss feed
    $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
    $sql = "select Description from wn18_RSS_Feeds where FeedID=" . $myID;
# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
    
    
    if(!isset($_SESSION['Feeds'])){$_SESSION['Feeds'] = array();}
    

    
    while($row = mysqli_fetch_assoc($result)){# process SQL

            // pulls the RSS feed link if not cached
            $request = dbOut($row['Description']);
        
            //no checks- verify data in the fields 
            $_SESSION['Feeds'][] = new Feed($myID, $request);
    
    dumpDie($_SESSION['Feeds'][1]);
 
        
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

    }
@mysqli_free_result($result);// end sql call and xml reader
 
}//end showFeeds()

class Feed
{
    public $myID = 0;
    public $Description = '';
    //public $TimeDate = '';
    
    public function __construct($myID, $Description)
    {
        $this->myID = $myID;
        $this->Description = $Description;
        //$this->TimeDate = $TimeDate;
        
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

