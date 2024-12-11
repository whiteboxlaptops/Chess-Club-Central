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

// chessdb.php
// Establish a database connection.

$mysql_host = 'localhost';
$mysql_login = 'admin';
$mysql_password = 'chess123';
$mysql_database = 'chess';

$c = mysql_pconnect ( $mysql_host, $mysql_login, $mysql_password );
if ( ! $c ) {
  echo "Sorry, had an error connecting to the database. The server appears to be down. Please try again later.<P>";
  exit;
}

if ( ! mysql_select_db ( $mysql_database ) ) {
  echo "Error selecting \"$mysql_database\" database!<P>" . mysql_error ();
  exit;
}
?>
