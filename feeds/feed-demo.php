<?
//feed.php
//our simplest example of consuming an RSS feed

  $request = "https://news.google.com/news/rss/search/section/q/Apple/Apple?hl=en&gl=US&ned=us";
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
   

    foreach($xml->channel->item as $story)
    {
        for($i = 1; $i < 4; $i++){
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
        }
    }


/*////////////////////////////////////////////////////////////////////////
function displayFeed($request){
    
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
  foreach($xml->channel->item as $story)
  {
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
  }
}//end displayFeed()

#this link uses info from db to display the xml - need the xml to be processed though 
<a href="https://news.google.com/news/rss/search/section/q/' . dbOut($row['SubCategory']) . '/' . dbOut($row['SubCategory']) . '?hl=en&gl=US&ned=us"</a>



*/
?>