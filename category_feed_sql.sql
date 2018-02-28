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
  Description text,
  PRIMARY KEY (FeedID),
  FOREIGN KEY (CategoryID) REFERENCES wn18_RSS_Categories(CategoryID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO wn18_RSS_Categories (Category, Description)
VALUES ('Technology', 'This is the description for the Technology category');

INSERT INTO wn18_RSS_Categories (Category, Description)
VALUES ('Music', 'This is the description for the Breaking News category');

INSERT INTO wn18_RSS_Categories (Category, Description)
VALUES ('Sports', 'This is the description for the Sports category');

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('Jazz', 'This is the description for Jazz', 2);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('Rock', 'This is the description for Rock', 2);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('Pop', 'This is the description for Pop', 2);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('Apple', 'This is the description for Apple', 1);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('Microsoft', 'This is the description for Microsoft', 1);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('Amazon', 'This is the description for Amazon', 1);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('MLB', 'This is the description for Major League Baseball', 3);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('NHL', 'This is the description for the National Hockey League', 3);

INSERT INTO wn18_RSS_Feeds (SubCategory, Description, CategoryID)
VALUES ('NBA', 'This is the description for the National Basketball Association', 3);

SET FOREIGN_KEY_CHECKS=1;