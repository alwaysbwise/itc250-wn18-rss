<?
//feed.php
//our simplest example of consuming an RSS feed

  $request = "https://news.google.com/news/rss/explore/section/q/National%20Basketball%20Association/National%20Basketball%20Association?hl=en&gl=US&ned=us";
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
?>