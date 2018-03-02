<?
//feed.php
//our simplest example of consuming an RSS feed
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index feed pages
  //$request = "https://news.google.com/news/rss/search/section/q/" . dbOut($row['SubCategory']) . '/' . dbOut($row['SubCategory']) . '?hl=en&gl=US&ned=us';
 
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "feeds/feed_view.php");
}


$sql = "select Description from wn18_RSS_Feeds where FeedID=" . $myID;

$prev = '<i class="fa fa-chevron-circle-left"></i>';
$next = '<i class="fa fa-chevron-circle-right"></i>';

# Create instance of new 'pager' class
$myPager = new Pager(20,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

while($row = mysqli_fetch_assoc($result))
	{# process each row
        $request = dbOut($row['Description']);
        $response = file_get_contents($request);
        $xml = simplexml_load_string($response);
        print '<h1>' . $xml->channel->title . '</h1>';
        foreach($xml->channel->item as $story)
          {
            echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
            echo '<p>' . $story->description . '</p><br /><br />';
          }
    
	}



@mysqli_free_result($result);

?>