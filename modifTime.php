<?php
header('content-type: text/html; charset=utf-8');
require ("laBDD.php");

require ("Parametres.php");

$laBase = new laBDD($hote, $user, $pass, $base);
$laBase->connexion();
?>

<html>
   <head>
      <meta content="text/html; charset=utf-8" http-equiv="content-type">
      <title></title>
      <link rel="stylesheet" href="Styles/style.css?ver=1.0" type="text/css" />
   </head>
	
	<?php
$sql = "SELECT user.nickname, UTC, start.monday, start.tuesday, start.wednesday, start.thursday, start.friday, start.saturday, start.sunday, end.monday, end.tuesday, end.wednesday, end.thursday, end.friday, end.saturday, end.sunday ";
$sql.= "FROM user INNER JOIN start ON user.nickname = start.nickname ";
$sql.= "INNER JOIN end ON start.nickname = end.nickname ";
$sql.= "WHERE user.nickname='" . $_GET['nickname'] . "'";
$result = $laBase->requete($sql);
$UTC = $result[0][1];
$startmonday = $result[0][2];
$starttuesday = $result[0][3];
$startwednesday = $result[0][4];
$startthursday = $result[0][5];
$startfriday = $result[0][6];
$startsaturday = $result[0][7];
$startsunday = $result[0][8];
$endmonday = $result[0][9];
$endtuesday = $result[0][10];
$endwednesday = $result[0][11];
$endthursday = $result[0][12];
$endfriday = $result[0][13];
$endsaturday = $result[0][14];
$endsunday = $result[0][15];
echo "<form action='' method='post' class='form-style-10'><h1>Modify your Available Hours</h1>";
echo "<input type='text'  id='nickname' name='nickname' placeholder='Your Nickname' value='" . $result[0][0] . "' />";
echo "<br />";
echo "<fieldset>";
echo "<legend>Monday</legend>";
echo "<div class=\"start\">";
echo "<input type=\"time\" id=\"start-monday\" name=\"start-monday\" value='" . $startmonday . "' />";
echo "<input type=\"time\" id=\"end-monday\" name=\"end-monday\" value='" . $endmonday . "' />";
echo "</div>";
echo "</fieldset>";
echo "<br />";
echo "<fieldset>";
echo "<legend>Tuesday</legend>";
echo "<div class=\"start\">";
echo "<input type=\"time\" id=\"start-tuesday\" name=\"start-tuesday\" value='" . $starttuesday . "' />";
echo "<input type=\"time\" id=\"end-tuesday\" name=\"end-tuesday\" value='" . $endtuesday . "' />";
echo "</div>";
echo "</fieldset>";
echo "<br />";
echo "<fieldset>";
echo "<legend>Wednesday</legend>";
echo "<div class=\"start\">";
echo "<input type=\"time\" id=\"start-wednesday\" name=\"start-wednesday\" value='" . $startwednesday . "' />";
echo "<input type=\"time\" id=\"end-wednesday\" name=\"end-wednesday\" value='" . $endwednesday . "' />";
echo "</div>";
echo "</fieldset>";
echo "<br />";
echo "<fieldset>";
echo "<legend>Thursday</legend>";
echo "<div class=\"start\">";
echo "<input type=\"time\" id=\"start-thursday\" name=\"start-thursday\" value='" . $startthursday . "' />";
echo "<input type=\"time\" id=\"end-thursday\" name=\"end-thursday\" value='" . $endthursday . "' />";
echo "</div>";
echo "</fieldset>";
echo "<br />";
echo "<fieldset>";
echo "<legend>Friday</legend>";
echo "<div class=\"start\">";
echo "<input type=\"time\" id=\"start-friday\" name=\"start-friday\"  value='" . $startfriday . "' />";
echo "<input type=\"time\" id=\"end-friday\" name=\"end-friday\" value='" . $endfriday . "' />";
echo "</div>";
echo "</fieldset>";
echo "<br />";
echo "<fieldset>";
echo "<legend>Saturday</legend>";
echo "<div class='start'>";
echo "<input type=\"time\" id=\"start-saturday\" name=\"start-saturday\" value='" . $startsaturday . "' />";
echo "<input type=\"time\" id=\"end-saturday\" name=\"end-saturday\" value='" . $endsaturday . "' />";
echo "</div>";
echo "</fieldset>";
echo "<br />";
echo "<fieldset>";
echo "<legend>Sunday</legend>";
echo "<div class=\"start\">";
echo "<input type=\"time\" id=\"start-sunday\" name=\"start-sunday\" value='" . $startsunday . "' />";
echo "<input type=\"time\" id=\"end-sunday\" name=\"end-sunday\" value='" . $endsunday . "' />";
echo "</div>";
echo "</fieldset>";
echo "<br />";
echo "<input type=\"submit\" name=\"modify\" value=\"Modify\" /></form><br />";
echo "</form>";

if (isset($_POST['modify']))
	{
	$nickname = $_POST['nickname'];
	$sql = "UPDATE user SET nickname='$nickname', UTC='$UTC' WHERE nickname='$nickname';";
	$result = $laBase->requete($sql);

	$startmonday = $_POST['start-monday'];
	$starttuesday = $_POST['start-tuesday'];
	$startwednesday = $_POST['start-wednesday'];
	$startthursday = $_POST['start-thursday'];
	$startfriday = $_POST['start-friday'];
	$startsaturday = $_POST['start-saturday'];
	$startsunday = $_POST['start-sunday'];
	$sql = "UPDATE start SET monday='$startmonday', tuesday='$starttuesday', wednesday='$startwednesday', thursday='$startthursday', friday='$startfriday', saturday='$startsaturday', sunday='$startsunday' WHERE nickname='$nickname';";
	$result = $laBase->requete($sql);

	$endmonday = $_POST['end-monday'];
	$endtuesday = $_POST['end-tuesday'];
	$endwednesday = $_POST['end-wednesday'];
	$endthursday = $_POST['end-thursday'];
	$endfriday = $_POST['end-friday'];
	$endsaturday = $_POST['end-saturday'];
	$endsunday = $_POST['end-sunday'];
	$sql = "UPDATE end SET monday='$endmonday', tuesday='$endtuesday', wednesday='$endwednesday', thursday='$endthursday', friday='$endfriday', saturday='$endsaturday', sunday='$endsunday' WHERE nickname='$nickname';";
	$result = $laBase->requete($sql);

	header("Location:index.php");
	}

?>