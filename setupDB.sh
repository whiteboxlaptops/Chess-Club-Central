#!/bin/bash

mysql -e '
create database chess;
use chess
CREATE TABLE `players` (
  `player_id` int(1) unsigned NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  `games_won` int(1) NOT NULL default '0',
  `games_tied` int(1) NOT NULL default '0',
  `games_lost` int(1) NOT NULL default '0',
  `rating` int(1) NOT NULL default '0',
  `comments` varchar(255) default NULL,
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `player_id`(`player_id`)
);

CREATE TABLE `games` (
  `game_id` int(1) unsigned NOT NULL auto_increment,
  `white_id` int(1) unsigned NOT NULL,
  `black_id` int(1) unsigned NOT NULL,
  `game_date` date default NULL,
  `outcome` char(1) NOT NULL,
  `moves` text NULL,
  PRIMARY KEY (`game_id`),
  UNIQUE KEY `game_id`(`game_id`),
  KEY `black_id`(`black_id`),
  KEY `white_id`(`white_id`)
);
'
