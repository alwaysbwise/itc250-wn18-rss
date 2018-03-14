/**
 * @package ITC250 Project 4
 * @author Benjamin Beal <bbeal003@seattlecentral.edu>
 * @version 2.0 02/27/2018
 * @link http://www.bsquaredproduction.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 */

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS wn18_RSS_Feeds;
DROP TABLE IF EXISTS wn18_RSS_Categories;

CREATE TABLE wn18_RSS_Categories (
  CategoryID int(10) unsigned NOT NULL AUTO_INCREMENT,
  Category varchar(120) DEFAULT NULL,
  Description text,
  PRIMARY KEY (CategoryID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE wn18_RSS_Feeds (
  FeedID int(10) unsigned NOT NULL AUTO_INCREMENT,
  CategoryID int(10) unsigned DEFAULT 0,
  SubCategory varchar(120) DEFAULT NULL,
  Description varchar(250),
  FeedXML varchar(250),
  PRIMARY KEY (FeedID),
  FOREIGN KEY (CategoryID) REFERENCES wn18_RSS_Categories(CategoryID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO wn18_RSS_Categories (Category, Description)
VALUES ('Music', 'This is the description for the Music News category');

INSERT INTO wn18_RSS_Categories (Category, Description)
VALUES ('Technology', 'This is the description for the Technology category');

INSERT INTO wn18_RSS_Categories (Category, Description)
VALUES ('Sports', 'This is the description for the Sports category');

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('Jazz', 'This is the description for the Jazz News category', 'https://news.google.com/news/rss/search/section/q/Jazz%20Music/Jazz%20Music?hl=en&gl=US&ned=us', 1);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('Rock', 'This is the description for the Rock News category', 'https://news.google.com/news/rss/search/section/q/Rock%20Music/Rock%20Music?hl=en&gl=US&ned=us', 1);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('Pop', 'This is the description for the Pop News category', 'https://news.google.com/news/rss/search/section/q/Pop%20Music/Pop%20Music?hl=en&gl=US&ned=us', 1);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('Apple', 'This is the description for the Apple News category', 'https://news.google.com/news/rss/explore/section/q/Apple/Apple?ned=us&hl=en&gl=US', 2);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('Microsoft', 'This is the description for the Microsoft News category', 'https://news.google.com/news/rss/search/section/q/Microsoft/Microsoft?hl=en&gl=US&ned=us', 2);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('Amazon', 'This is the description for the Amazon News category', 'https://news.google.com/news/rss/search/section/q/Amazon/Amazon?hl=en&gl=US&ned=us', 2);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('MLB', 'This is the description for the Baseball News category', 'https://news.google.com/news/rss/explore/section/q/Major%20League%20Baseball/Major%20League%20Baseball?hl=en&gl=US&ned=us', 3);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('NHL', 'This is the description for the Hockey News category', 'https://news.google.com/news/rss/explore/section/q/National%20Hockey%20League/National%20Hockey%20League?hl=en&gl=US&ned=us', 3);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, FeedXML, CategoryID)
VALUES ('NBA', 'This is the description for the Basketball News category', 'https://news.google.com/news/rss/explore/section/q/National%20Basketball%20Association/National%20Basketball%20Association?hl=en&gl=US&ned=us', 3);



SET FOREIGN_KEY_CHECKS=1;