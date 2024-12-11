<?php

/* Chess Club Central written by Geoff Peters (gpeters@sfu.ca).
Copyright (c) 2005 Geoff Peters

This file is part of Chess Club Central.

Chess Club Central is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Chess Club Central is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Chess Club Central (COPYING.TXT); if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/******************************************************************/
/* The following parameters are user-configurable
and should be changed. */

// to change the system password, change this value
$system_password = "chess123";

// the name of your chess club
$chessclubname = "Justin's stupid club and stuff Chess Club";

// you can add more directories to your include path here
//ini_set( 'include_path', '/home/geoff/ultra:.:/usr/share/php:/usr/share/pear:/home/geoff/ultra/PEAR-1.3.4');

/********************************************************************/


// load the MYSQL Database
require("chessdb.php");


////////////////////////////////////////////////////////////
// Class holding the information about a game score
// and ratings.
class GameScore
{
	var $white_id;   // id of white player
	var $white_name; // name of white player
	var $white_old;  // old rating
	var $white_new;  // new rating

	var $black_id;
	var $black_name;
	var $black_old;
	var $black_new;
}

////////////////////////////////////////////////////////////
// Class holding the information about a player
class Player
{
	var $player_id;
	var $name;
	var $games_won;
	var $games_tied;
	var $games_lost;
	var $rating;
	var $comments;
}

////////////////////////////////////////////////////////////
// Shows beginning of page
function print_page_start( $access )
{

global $chessclubname;

print("<html>

<head>
<meta http-equiv=\"Content-Language\" content=\"en-ca\">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">
<title>Geoff's Chess Club Central</title>
</head>

<body bgcolor=\"#594F5A\">

<table border=\"0\" cellpadding=\"5\" cellspacing=\"10\" width=\"100%\" bgcolor=\"#BDC5D2\">
  <tr>
    <td width=\"100%\" bgcolor=\"#7F93AE\">
      <table border=\"0\"  cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">
        <tr>
          <td width=\"100%\">
            <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">
              <tr>
                <td width=\"50%\" bgcolor=\"#7F93AE\" valign=\"top\"><font face=\"Arial\" size=\"5\" color=\"#FFFFFF\"><b>Geoff's
                  Chess Club Central<br>
                  &nbsp;&nbsp;&nbsp;</b></font></td>
                <td width=\"50%\" bgcolor=\"#7F93AE\" valign=\"top\">
                  <p align=\"right\"><font color=\"#FFFFFF\">
                  Software to manage your chess club rankings. Created by</font> <a href=\"http://www.sfu.ca/~gpeters/\"><font color=\"#FFFFFF\">Geoff Peters</font></a></td>
              </tr>
            </table>
            <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">
              <tr>
                <td width=\"150\" bgcolor=\"#7F93AE\" valign=\"top\"><b>&nbsp; <br>
                  &nbsp;</b>
                  <table border=\"0\" cellpadding=\"5\" cellspacing=\"1\" width=\"90%\" bgcolor=\"#000000\">
                    <tr>
                      <td width=\"100%\" bgcolor=\"#FFFFFF\">
                        <p align=\"left\">You are viewing: <b>$chessclubname</b>.");

	if( $access )
	{
		print("<br><a href=\"?go=logout\">Logout</a>");
	}
	else
	{
		//print("<br>Public access");
	}

	print("</td>
                    </tr>
                  </table>
                  <p align=\"left\"><b><font color=\"#FFFFFF\">Reports</font><br>
                  </b><a href=\"?go=view_players\"><font color=\"#FFFFFF\">View Players</font></a><br>
                  <a href=\"?go=view_games\"><font color=\"#FFFFFF\">
                  View Games</font></a></p>

				  <p align=\"left\"><b><font color=\"#FFFFFF\">Actions</font><br>
                  </b><a href=\"?go=add_game\"><font color=\"#FFFFFF\">Add New Game</font></a><br>
                  <a href=\"?go=add_player\"><font color=\"#FFFFFF\">
                  Add New Player</font></a><br>
                  <a href=\"?go=edit_player\"><font color=\"#FFFFFF\">
                  Edit Player</font></a></p>
                  </td>
                <td bgcolor=\"#FFFFFF\" valign=\"top\">
                  <table border=\"0\" cellpadding=\"15\" cellspacing=\"0\" width=\"100%\">
                    <tr>
                    <td width=\"100%\">
                    <!-- main content goes here -->
");
}

/////////////////////////////////////////////////////////////////////
// Shows end of page
function print_page_end()
{
print("

                        <!-- end of main content -->
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
  <td>
  <p align=\"center\"><b>Chess Club Central</b> designed by Geoff Peters. Copyright (c) 2008 <a href=\"http://www.sfu.ca/~gpeters/\">Geoff Peters</a>.<br>
  Comments or bugs? Please email <a href=\"mailto:gpeters@sfu.ca\">gpeters@sfu.ca</a>.
  </td>
  </tr>
</table>

</body>

</html>
");
}

//////////////////////////////////////////////
// Show the add player form
function show_add_player_form()
{
print("
     <b>Add Player</b>
                        <form method=\"POST\" action=\"chess.php\">
                          <p>&nbsp;</p>
                          <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                            <tr>
                              <td>Player Name</td>
                              <td><input type=\"text\" name=\"name\" size=\"20\"></td>
                            </tr>
                            <tr>
                              <td>Initial Rating</td>
                              <td><input type=\"text\" name=\"rating\" size=\"20\" value=\"1200\"></td>
                            </tr>
                            <tr>
                              <td>Games Won</td>
                              <td><input type=\"text\" name=\"games_won\" size=\"20\" value=\"0\"></td>
                            </tr>
                            <tr>
                              <td>Games Tied</td>
                              <td><input type=\"text\" name=\"games_tied\" size=\"20\" value=\"0\"></td>
                            </tr>
                            <tr>
                              <td>Games Lost</td>
                              <td><input type=\"text\" name=\"games_lost\" size=\"20\" value=\"0\"></td>
                            </tr>
                            <tr>
                              <td>Comments</td>
                              <td><input type=\"text\" name=\"comments\" size=\"43\"></td>
                            </tr>
                          </table>
                          <p><input type=\"submit\" value=\"Save\"></p>
                          <input type=\"hidden\" name=\"action\" value=\"save\"><input type=\"hidden\" name=\"go\" value=\"add_player\">
                        </form>
");
}

/////////////////////////////////////////
// adds a player to the database
function add_player()
{
	$name = get_request_param('name');
	$rating = get_request_param('rating');
	$games_won = get_request_param('games_won');
	$games_tied = get_request_param('games_tied');
	$games_lost = get_request_param('games_lost');
	$comments = get_request_param('comments');

	$name = trim($name);

	if( $name == "" )
	{
		print("Sorry, the player's name cannot be blank. Please try again.");
		return false;
	}

	$sql = "INSERT INTO players (name,games_won, games_tied, games_lost, rating, comments) VALUES ('"
	. $name ."', '"
	. $games_won ."', '"
	. $games_tied ."', '"
	. $games_lost ."', '"
	. $rating ."', '"
	. $comments ."')";

	//print( $sql );
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print_debug( "MySQL Error 2: " . mysql_error() . "<p>");
		return false;
	}

	print("The player was added.");
}

//////////////////////////////////////////////
// Loads a player's information
function load_player( $player_id, &$player )
{
	// determine if the word is already in the database
	$sql = "select player_id, name, games_won, games_tied, games_lost, rating, comments from players where player_id='$player_id'";
	//print_debug( $sql);
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print_debug( "MySQL Error: " . mysql_error() . "<p>");
		return false;
	}

	if ( mysql_num_rows($res) == 0 )
	{
		return false;   // not found
	}
	else // if player in database
	{
		$myrow = mysql_fetch_row($res);

		$player = new Player;

		$player->player_id = $myrow[0];
		$player->name = $myrow[1];
		$player->games_won = $myrow[2];
		$player->games_tied = $myrow[3];
		$player->games_lost = $myrow[4];
		$player->rating = $myrow[5];
		$player->comments = $myrow[6];
	}

	return true;
}

//////////////////////////////////////////////
// Show the edit player form
function show_edit_player_form()
{
	$player = get_request_param('player');

	if( ! get_player_list( $players ))
	{
		print("Unable to get the player list. Please try again later.");
		return false;
	}

print("
     <b>Edit Player</b>

		                <form method=\"GET\" action=\"chess.php\">
                          <p>&nbsp;</p>
                          <select size=\"1\" name=\"player\">
                                  <option value=\"-1\">Select Player</option>");

	$total_players = count( $players );
	for( $i = 0; $i < $total_players; $i++)
		{
			print("<option");

			// if the current player was previously selected,
			// then select it again
			if( $player == $players[$i][1] )
				{
				print(" selected");
				}
			print(" value=\"" . $players[$i][1] . "\">" .
				$players[$i][0] . "</option>\n");
		}
	 print("
	 </select>
<input type=\"submit\" value=\"Load Player\"></p>
                          <input type=\"hidden\" name=\"action\" value=\"\"><input type=\"hidden\" name=\"go\" value=\"edit_player\">
		 </form>");

	if( $player != "" )
	{
		if( ! load_player( $player, $player_info ) )
		{
			print("Unable to load player.");
			return false;
		}

		print("         <form method=\"POST\" action=\"chess.php\">
                          <p>&nbsp;</p>
                          <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                            <tr>
                              <td>Player Name</td>
                              <td><input type=\"text\" name=\"name\" size=\"20\" value=\"". htmlspecialchars( $player_info->name ). "\"></td>
                            </tr>
                            <tr>
                              <td>Current Rating</td>
                              <td><input type=\"text\" name=\"rating\" size=\"20\" value=\"". $player_info->rating . "\"></td>
                            </tr>
                            <tr>
                              <td>Games Won</td>
                              <td><input type=\"text\" name=\"games_won\" size=\"20\" value=\"". $player_info->games_won . "\"></td>
                            </tr>
                            <tr>
                              <td>Games Tied</td>
                              <td><input type=\"text\" name=\"games_tied\" size=\"20\" value=\"". $player_info->games_tied . "\"></td>
                            </tr>
                            <tr>
                              <td>Games Lost</td>
                              <td><input type=\"text\" name=\"games_lost\" size=\"20\" value=\"". $player_info->games_lost . "\"></td>
                            </tr>
                            <tr>
                              <td>Comments</td>
                              <td><input type=\"text\" name=\"comments\" size=\"43\" value=\"". htmlspecialchars( $player_info->comments ) . "\"></td>
                            </tr>
                          </table>
                          <p><input type=\"submit\" value=\"Save\"></p>
                          <input type=\"hidden\" name=\"action\" value=\"save\">
						  <input type=\"hidden\" name=\"player_id\" value=\"". $player_info->player_id . "\">
						  <input type=\"hidden\" name=\"go\" value=\"edit_player\">
                        </form>
");
	}
}


/////////////////////////////////////////////////////////////////
// Updates the player information when it is edited directly
function edit_player()
{
	$player_id = get_request_param('player_id');
	$name = get_request_param('name');
	$games_won = get_request_param('games_won');
	$games_tied = get_request_param('games_tied');
	$games_lost = get_request_param('games_lost');
	$rating = get_request_param('rating');
	$comments = get_request_param('comments');

	$name = trim($name);
	if( $name == "" )
	{
		print_error( "Please enter a name for the player.");
		return false;
	}

	$sql = "UPDATE players p SET p.name='$name', p.games_won='$games_won', p.games_tied='$games_tied', p.games_lost='$games_lost', p.rating='$rating', p.comments='$comments' WHERE p.player_id = '$player_id'";
//		print( $sql );
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print( "MySQL Error: " . mysql_error() . "<p>");
		return false;
	}

	print("<p>Thank you. The player's information has been updated.</p>
	");

	return true;
}

/////////////////////////////////
// Shows password entry form
function show_password_form($go, $password_incorrect)
{
	print("
 <p><b>Enter Password</b></p>
                        <p>A password is required to access this feature. Please
                        enter the password below.</p>
                    <form method=\"POST\" action=\"chess.php\">
                      <p><input type=\"password\" name=\"trypass\" size=\"20\"><input type=\"submit\" value=\"Submit\" name=\"B1\"></p>
                      <input type=\"hidden\" name=\"go\" value=\"$go\">
                    </form>
");
if ($password_incorrect )
	{
	print("<p>Sorry, the password was incorrect. Please try again.</p>");
	}
}

///////////////////////////////////////////////////////////
/*
Calculate the player's new rating using a formula.

Rating(New) = Rating(Old) + K[S - S(Expected)]

Where:
K = 16
S = +1 for win, 0.5 for draw, 0 for loss.
S(Expected) = 1/[10^(DR/400) + 1]
DR = Difference in Ratings = Opponent's Rating(Old) - Rating(Old)
*/
// Gets the new rating for a player.
function get_new_rating( $my_old, $opp_old, &$my_new, $s )
{
	//print( "\n\nmy_old = $my_old\nopp_old = $opp_old\ns = $s\n");

	$dr = $opp_old - $my_old;
	$s_expected = 1.0 / ( pow(10, ($dr / 400.0)) + 1 );

	$k = 16;

	$change = round( $k * ($s - $s_expected) );
	$my_new = $my_old + $change;

	return true;
}

///////////////////////////////////////////////////////
// Looks up a player's current rating and name
function get_current_rating( $player_id, &$rating, &$name )
{

	$sql = "select rating, name from players where player_id='". $player_id ."'";
	//print_debug( $sql);
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print_debug( "MySQL Error: " . mysql_error() . "<p>");
		return false;
	}

	if ( mysql_num_rows($res) == 0 )
	{
		return false;   // not found
	}
	else // if found in database
	{
		$myrow = mysql_fetch_row($res);
		$rating = $myrow[0];
		$name = $myrow[1];
	}
	return true;
}

////////////////////////////////////////////////
// Calculates the chess score
function calculate_score( $white_id, $black_id, $outcome, &$score )
{
	if( $white_id == $black_id )
	{
		print("Sorry, a player cannot play against him/herself.");
		return false;
	}

	if( $white_id == "-1" )
	{
		print("Please select a player for white.");
		return false;
	}

	if( $black_id == "-1" )
	{
		print("Please select a player for black.");
		return false;
	}

	if( $outcome != "1" && $outcome != "0" && $outcome != "5" )
	{
		print("Please select an outcome.");
		return false;
	}

	if( ! get_current_rating( $white_id, $white_old, $white_name ) )
	{
		return false;
	}
	if( ! get_current_rating( $black_id, $black_old, $black_name ) )
	{
		return false;
	}

	if( $outcome == "1" ) // white wins
	{
		// calculate for white
		get_new_rating( $white_old, $black_old, $white_new, 1 );

		// calculate for black
		get_new_rating( $black_old, $white_old, $black_new, 0 );
	}
	else if( $outcome == "0" ) // black wins
	{
		// calculate for white
		get_new_rating( $white_old, $black_old, $white_new, 0 );

		// calculate for black
		get_new_rating( $black_old, $white_old, $black_new, 1 );
	}
	else if( $outcome == "5" ) // tie
	{
		// calculate for white
		get_new_rating( $white_old, $black_old, $white_new, 0.5 );

		// calculate for black
		get_new_rating( $black_old, $white_old, $black_new, 0.5 );
	}

	$score = new GameScore;

	$score->white_id = $white_id;
	$score->white_name = $white_name;
	$score->white_old = $white_old;
	$score->white_new = $white_new;

	$score->black_id = $black_id;
	$score->black_name = $black_name;
	$score->black_old = $black_old;
	$score->black_new = $black_new;

	return true;
}

////////////////////////////////////////////////
// Updates one player's rankings
function update_player_ranking( $player_id, $new_rating, $won, $tied, $lost )
{
		$sql = "UPDATE players SET games_won = games_won + '" . $won
			. "', games_tied = games_tied + '" .$tied
				. "', games_lost = games_lost + '" .$lost .
			"', rating = '" . $new_rating . "' WHERE player_id='$player_id'";
		//print_debug( $sql );
		$res = mysql_query($sql);
		if (mysql_error())
		{
			print( "MySQL Error 2a: " . mysql_error() . "<p>");
			return false;
		}
		return true;
}

////////////////////////////////////////////////
// Updates the players rankings after a game
function update_rankings( $score, $outcome )
{
	if( $outcome == "1" ) // white won
	{
		// update white
		if( ! update_player_ranking( $score->white_id, $score->white_new, 1, 0, 0 ))
		{
			return false;
		}

		// update black
		if( ! update_player_ranking( $score->black_id, $score->black_new, 0, 0, 1 ))
		{
			return false;
		}
	}
	else if( $outcome == "0" ) // black won
	{
		// update white
		if( ! update_player_ranking( $score->white_id, $score->white_new, 0, 0, 1 ))
		{
			return false;
		}
		// update black
		if( ! update_player_ranking( $score->black_id, $score->black_new, 1, 0, 0 ))
		{
			return false;
		}
	}
	else if( $outcome == "5" ) // tied
	{
		// update white
		if( ! update_player_ranking( $score->white_id, $score->white_new, 0, 1, 0 ))
		{
			return false;
		}

		// update black
		if( ! update_player_ranking( $score->black_id, $score->black_new, 0, 1, 0 ))
		{
			return false;
		}
	}
	else
	{
		return false;
	}

	return true;
}

///////////////////////////////////////////////////
// Populates an array of player names
// and their ID's, sorted by name
function get_player_list( &$players )
{

	$sql = "select name, player_id from players ORDER BY name ASC";
	//print_debug( $sql);
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print_debug( "MySQL Error: " . mysql_error() . "<p>");
		return false;
	}

	if ( mysql_num_rows($res) == 0 )
	{
		return false;   // not found
	}
	else // if found in database, get the rows
	{
		$index = 0;
		while( $myrow = mysql_fetch_row($res) )
		{
			$players[$index][0] = $myrow[0];
			$players[$index][1] = $myrow[1];
			$index++;
		}
	}

	return true;
}

///////////////////////////////////////
// Shows add game form
function show_add_game_form( $action )
{
	$white_id = get_request_param('white_id');
	$black_id = get_request_param('black_id');
	$outcome = get_request_param('outcome');

	if( ! get_player_list( $players ))
	{
		print("Unable to get the player list. Please try again later.");
		return false;
	}

print("
<b>Add New Game</b>
                        <form method=\"POST\" action=\"chess.php\">
                          <p>&nbsp;</p>
                          <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\">
                            <tr>
                              <td width=\"50%\">White</td>
                              <td width=\"50%\"><select size=\"1\" name=\"white_id\">
                                  <option value=\"-1\">Select Player</option>");

	$total_players = count( $players );
	for( $i = 0; $i < $total_players; $i++)
		{
			print("<option");

			// if the current player was previously selected,
			// then select it again
			if( $white_id == $players[$i][1] )
				{
				print(" selected");
				}
			print(" value=\"" . $players[$i][1] . "\">" .
				$players[$i][0] . "</option>\n");
		}
	 print("
	 </select></td>
                            </tr>
                            <tr>
                              <td width=\"50%\">Black</td>
                              <td width=\"50%\"><select size=\"1\" name=\"black_id\">
                                  <option value=\"-1\">Select Player</option>");

	for( $i = 0; $i < $total_players; $i++)
		{
			print("<option");

			// if the current player was previously selected,
			// then select it again
			if( $black_id == $players[$i][1] )
				{
				print(" selected");
				}
			print(" value=\"" . $players[$i][1] . "\">" .
				$players[$i][0] . "</option>\n");
		}

   print("
                                </select></td>
                            </tr>
                            <tr>
                              <td width=\"50%\">Outcome</td>
                              <td width=\"50%\"><select size=\"1\" name=\"outcome\">
                                  <option>Select Outcome</option>
                                  <option ");
	if( $outcome == "1" )
	{
		print("selected ");
	}
	print("value=\"1\">1 - 0 (white wins)</option>
                                  <option ");
	if( $outcome == "0" )
	{
		print("selected ");
	}
	print("value=\"0\">0 - 1 (black wins)</option>
                                  <option ");
	if( $outcome == "5" )
	{
		print("selected ");
	}
	print("value=\"5\">1/2 - 1/2 (tie)</option>
                                </select></td>
                            </tr>
                          </table>
                          <p><input type=\"submit\" value=\"Calculate Score\" name=\"calculate\"></p>

	                          <input type=\"hidden\" name=\"action\" value=\"calculate\"><input type=\"hidden\" name=\"go\" value=\"add_game\">
                        </form>
                        ");

if( $action == "calculate" )
	{

	// calculate score
	if( ! calculate_score( $white_id, $black_id, $outcome, $score ) )
	{
		// if couldn't calculate score
		print(" Couldn't calculate score.");
		return false;
	}

	print("<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
                            <tr>
                              <td>Player</td>
                              <td>Rating Before</td>
                              <td>Rating After</td>
                            </tr>
                            <tr>
                              <td>$score->white_name</td>
                              <td>$score->white_old</td>
                              <td>$score->white_new</td>
                            </tr>
                            <tr>
                              <td>$score->black_name</td>
                              <td>$score->black_old</td>
                              <td>$score->black_new</td>
                            </tr>
                          </table>

                        <form method=\"POST\" action=\"chess.php\">
                          <p><br>
                          Input game moves (optional):</p>
                          <p><textarea rows=\"5\" name=\"moves\" cols=\"30\"></textarea><br>
                          <br>
                          <input type=\"submit\" value=\"Save Game\" name=\"B1\"></p>
                          <input type=\"hidden\" name=\"action\" value=\"save\"><input type=\"hidden\" name=\"go\" value=\"add_game\">
<input type=\"hidden\" name=\"white_id\" value=\"$white_id\">
<input type=\"hidden\" name=\"black_id\" value=\"$black_id\">
<input type=\"hidden\" name=\"outcome\" value=\"$outcome\">
                        </form>

");
	}
}

///////////////////////////////////////////////
// Adds a game
function add_game()
{
	$white_id = get_request_param('white_id');
	$black_id = get_request_param('black_id');
	$outcome = get_request_param('outcome');
	$moves = get_request_param('moves');

	// calculate score
	if( ! calculate_score( $white_id, $black_id, $outcome, $score ) )
	{
		// if couldn't calculate score
		print(" Couldn't calculate score.");
		return false;
	}

	// update the rankings
	if( ! update_rankings( $score, $outcome ) )
	{
		print("Sorry, unable to update the rankings.");
		return false;
	}

	// update the game table

	// use current date
	$game_date = date ("Y-m-d");

	$moves = trim($moves);

	if( $moves == "" )
	{
		$sql = "INSERT INTO games (white_id,black_id, game_date, outcome) VALUES ('"
	. $white_id ."', '"
	. $black_id ."', '"
	. $game_date ."', '"
	. $outcome ."')";
	}
	else if( $moves != "" )
	{
		$sql = "INSERT INTO games (white_id,black_id, game_date, outcome, moves) VALUES ('"
	. $white_id ."', '"
	. $black_id ."', '"
	. $game_date ."', '"
	. $outcome ."', '"
	. $moves . "')";
	}


	//print( $sql );
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print_debug( "MySQL Error 2: " . mysql_error() . "<p>");
		return false;
	}
print("The game has been added and the players rankings have been updated.");
}

///////////////////////////////////////////////
// Views players report
function view_players()
{
	$sort = get_request_param('sort');

print("
<b>View Players</b>
                        <p>Sort by: <a href=\"?go=view_players&sort=name\">Name</a>, <a href=\"?go=view_players&sort=played\">Games Played</a>, <a href=\"?go=view_players&sort=win\">Win %</a>, <a href=\"?go=view_players&sort=rating\">Rating</a></p>
                        <table border=\"1\" cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">
                          <tr>
                            <td>&nbsp;</td>
                            <td>Name</td>
                            <td>Games Played</td>
                            <td>Win %</td>
                            <td>Rating</td>
                          </tr>");
	if ($sort == "name")
	{
		$order = "name ASC";
	}
	else if ($sort == "played")
	{
		$order = "played DESC";
	}
	else if( $sort == "win" )
	{
		$order = "win DESC";
	}
	else // sort by rating by default
	{
		$order = "rating DESC";
	}


$sql = "select player_id, name, (games_won + games_tied + games_lost) as played, games_won / (games_won + games_tied + games_lost) as win, rating FROM players ORDER BY $order";

	//print_debug( $sql);
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print_debug( "MySQL Error: " . mysql_error() . "<p>");
		return false;
	}

	$index = 1;
	while( $myrow = mysql_fetch_row($res) )
	{
		print("
					  <tr>
						<td>$index</td>
						<td>" . $myrow[1] . "</td>
						<td>" . $myrow[2] . "</td>
						<td>" . number_format( $myrow[3] * 100, 2 ) . " %</td>
						<td>" . $myrow[4] . "</td>
					  </tr>" );

	  $index++;

	}
	print("
                        </table>

");
}

///////////////////////////////////////////////
// Views games
function view_games()
{
	$month = get_request_param('month');
	$year = get_request_param('year');

print("
<b>View Games</b>
                        <p>&nbsp; </p>

   <form method=\"GET\" action=\"chess.php\">
      Show games that occurred in:<br><select size=\"1\" name=\"month\">
");

	if( $month == "" || $year == "" )
	{
		$month = date("n");
		$year = date("Y");
	}
	$current_year = date("Y");

	print("<option value=\"1\"");
	if( $month == 1 )
	{
		print( " selected");
	}
	print(">January</option>");
	print("<option value=\"2\"");
	if( $month == 2 )
	{
		print( " selected");
	}
	print(">February</option>");
	print("<option value=\"3\"");
	if( $month == 3 )
	{
		print( " selected");
	}
	print(">March</option>");
	print("<option value=\"4\"");
	if( $month == 4 )
	{
		print( " selected");
	}
	print(">April</option>");
	print("<option value=\"5\"");
	if( $month == 5 )
	{
		print( " selected");
	}
	print(">May</option>");
	print("<option value=\"6\"");
	if( $month == 6 )
	{
		print( " selected");
	}
	print(">June</option>");
	print("<option value=\"7\"");
	if( $month == 7 )
	{
		print( " selected");
	}
	print(">July</option>");
	print("<option value=\"8\"");
	if( $month == 8 )
	{
		print( " selected");
	}
	print(">August</option>");
	print("<option value=\"9\"");
	if( $month == 9 )
	{
		print( " selected");
	}
	print(">September</option>");
	print("<option value=\"10\"");
	if( $month == 10 )
	{
		print( " selected");
	}
	print(">October</option>");
	print("<option value=\"11\"");
	if( $month == 11 )
	{
		print( " selected");
	}
	print(">November</option>");
	print("<option value=\"12\"");
	if( $month == 12 )
	{
		print( " selected");
	}
	print(">December</option>");

	print("
      </select>&nbsp; <select size=\"1\" name=\"year\">");

	for( $y = 2005; $y <= $current_year; $y++ )
	{
		print("<option value=\"$y\"");
		if( $year == $y )
		{
			print( " selected");
		}
		print(">$y</option>");
	}

	print("</select> <input type=\"submit\" value=\"View Games\">
      <input type=\"hidden\" name=\"go\" value=\"view_games\">
    </form><br>\n");

                 print("
				 <table border=\"1\" cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">
                          <tr>
                            <td>Date</td>
                            <td>White</td>
                            <td>Black</td>
                            <td>Outcome</td>
                            <td>Moves</td>
                          </tr>");

$sql = "select g.game_id, g.game_date, g.white_id, w.name, g.black_id, b.name, g.outcome, g.moves from games g, players w, players b WHERE g.white_id = w.player_id AND g.black_id = b.player_id AND g.game_date >= '$year-$month-1' AND g.game_date < adddate( '$year-$month-1', INTERVAL 1 MONTH ) ORDER BY g.game_date DESC, g.game_id DESC";

	//print_debug( $sql);
	$res = mysql_query($sql);
	if (mysql_error())
	{
		print_debug( "MySQL Error: " . mysql_error() . "<p>");
		return false;
	}

	if ( mysql_num_rows($res) == 0 )
	{
		return false;   // not found
	}
	else // if found in database, get the rows
	{
		$index = 0;
		while( $myrow = mysql_fetch_row($res) )
		{
			print("
			<tr>
								<td>" . $myrow[1] . "</td>
								<td>" . $myrow[3] . "</td>
								<td>" . $myrow[5] . "</td>
								<td>");

			if( $myrow[6] == "1" )
				{
				print( "1 - 0" );
				}
				else if ( $myrow[6] == "0" )
				{
					print( "0 - 1" );
				}
				else
				{
					print( "1/2 - 1/2" );
				}

			print("</td> <td>");

			if( $myrow[7] != "" )
			{
				print("<a href=\"?go=view_moves&game_id=1\">View Moves</a>");
			}
			else
			{
				print("&nbsp;");
			}

			print("</td>
							  </tr>
								  ");
		}

		print("
                        </table>
                     ");
	}
	return true;
}

//////////////////////////////////////////////
// views moves of a game
function view_moves()
{
print(" Here's where I'd show the moves for the game");
}

/////////////////////////////////////////////////////
function get_request_param( $name )
{
	if ( isset($_REQUEST[$name]) )
	{
		return $_REQUEST[$name];
	}
	else
	{
		return "";
	}
}

//////////////////////////////////////////////////////
/* Main part of script */


$trypass = get_request_param('trypass');
$go = get_request_param('go');
$action = get_request_param('action');

$access = false;
$password_incorrect = false;
// check if we are authorized to use the password protected stuff
if( $trypass == $system_password )
{
	$access = true;
	$password = md5($system_password);

	setcookie("auth", $password, time()+60*60);  /* expire in 1 hour */
}
else if( $trypass <> "" )
{
	$password_incorrect = true;
}
else
{ // read cookie
	$password = $_COOKIE["auth"];

	if ( $password == md5($system_password) )
	{
		setcookie("auth", $password, time()+60*60);  /* re-set the expiry time to 1 hour */
		$access = true;
	}
}

// handle the logout
if( $go == "logout" )
{
	// clear the password and remove access
	setcookie("auth", "" );
	$password = "";
	$access = false;
	$go = "view_games";
}

print_page_start( $access );

// select action
if( $go == "view_players" )
{
	view_players();
}
else if ( $go == "view_games" || $go == "" )
{
	view_games();
}
else if ( $go == "view_moves" )
{
	view_moves();
}
else if( $access )
{
	if( $go == "add_player"  )
	{
		if( $action == "" )
		{
			show_add_player_form();
		}
		else if ($action == "save" )
		{
			add_player();
		}
	}
	if( $go == "edit_player"  )
	{
		if( $action == "" )
		{
			show_edit_player_form();
		}
		else if ($action == "save" )
		{
			edit_player();
		}
	}
	else if ( $go == "add_game" )
	{
		if( $action == "" || $action == "calculate" )
		{
			show_add_game_form( $action );
		}
		else if ($action == "save" )
		{
			add_game();
		}
	}
}
else
{
	show_password_form( $go, $password_incorrect );
}

print_page_end();
?>
