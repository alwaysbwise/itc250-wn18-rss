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
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "feeds/feed_view.php");
}

$sql = "select Description from wn18_RSS_Feeds where FeedID=" . $myID;

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

while($row = mysqli_fetch_assoc($result))
	{# process SQL
    
        // pulls the RSS feed link
        $request = dbOut($row['Description']);
        // takes the contents of the xml file and loads them
        $response = file_get_contents($request);
        $xml = simplexml_load_string($response);
    
        // display the title of the channel
        print '<h1>' . $xml->channel->title . '</h1>';
        
        // process through the array of stories and display link+title+description
        foreach($xml->channel->item as $story)
          {
            echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
            echo '<p>' . $story->description . '</p><br /><br />';
          }
    
	}

@mysqli_free_result($result);

?>