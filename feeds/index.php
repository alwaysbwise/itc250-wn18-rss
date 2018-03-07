<?php
/*
 * index.php is the first page of our News Aggregator app; it's based on
 * demo_list_pager.php along with demo_view_pager.php provides a sample web application
 * 
 * @package wn18/feeds
 * @author Brian Wise <briandwise7@gmail.com> Ana, Ben, Sue
 * @version 0.1 2018/02/08
 * @link http://www.brianwise.xyz/wn18
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see feed_view.php
 * @see feed.php 
 * @see Pager.php 
 * @todo set up sessions
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql= "select * from " . PREFIX . "RSS_Categories";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'News Feed Categories';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 Class News Feeds are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'RSS,PHP,Fun,News,Big Data,Regular Expressions,'. $config->metaKeywords;

//adds font awesome icons for arrows on pager
$config->loadhead .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center">Categories</h3>

<?php
#reference images for pager
//$prev = '<img src="' . $config->virtual_path . '/images/arrow_prev.gif" border="0" />';
//$next = '<img src="' . $config->virtual_path . '/images/arrow_next.gif" border="0" />';

#images in this case are from font awesome
$prev = '<i class="fa fa-chevron-circle-left"></i>';
$next = '<i class="fa fa-chevron-circle-right"></i>';

# Create instance of new 'pager' class
$myPager = new Pager(20,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "category";}else{$itemz = "categories";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
    echo '
    <table class="table table-hover">
    <thead>
        <tr>
          <th scope="col">Category</th>
          <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
    ';
	while($row = mysqli_fetch_assoc($result))
	{# process each row
        echo '
            <tr>
              <td><a href="' . VIRTUAL_PATH . 'feeds/feed_view.php?id=' . (int)$row['CategoryID'] . '">' . dbOut($row['Category']) . '</a></td>
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
    echo "<div align=center>There are currently no feeds.</div>";	
}
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
