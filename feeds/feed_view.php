<?php
/**
 * feed_view.php is a page to display the subcategories from their
 * respective parents and link to specific RSS feeds
 * 
 * @package RSS Feeds
 * @author Brian Wise <briandwise7@gmail.com> Ana, Ben, Sue
 * @version 0.1 2018/02/08
 * @link http://www.brianwise.xyz/wn18
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index feed pages

# check variable of item passed in - if invalid data, forcibly redirect back to feeds/index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "feeds/index.php");
}

?>
<h3 align="center">Sub-Categories</h3>
<?php
////////////////////////////////////////////////////////////////////////
$sql = "select * from wn18_RSS_Feeds where CategoryID=" . $myID;

$prev = '<i class="fa fa-chevron-circle-left"></i>';
$next = '<i class="fa fa-chevron-circle-right"></i>';

# Create instance of new 'pager' class
$myPager = new Pager(20,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset
//$sqlRSS = "select Description from wn18_RSS_Feeds where FeedID=" . $feedID;
# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "sub-category";}else{$itemz = "sub-categories";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
    echo '
    <table class="table table-hover">
    <thead>
        <tr>
          <th scope="col">Sub-Category</th>
          <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
    ';
	while($row = mysqli_fetch_assoc($result))
	{# process each row
        echo '
            <tr>            
              <td><a href="' . VIRTUAL_PATH . 'feeds/feed.php?id=' . (int)$row['FeedID'] . '">'. dbOut($row['SubCategory']) . '
              </a>
              </td>
              <td>'. dbOut($row['Description']) . '</td>
            </tr>
        ';
	}
    echo '
         </tbody>
    </table>
    ';
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>There are currently no sub-categories.</div>";	
}
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php


