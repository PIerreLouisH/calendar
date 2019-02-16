<!DOCTYPE html>
<?php
require ("laBDD.php");
require ("Parametres.php");

$laBase = new laBDD($hote, $user, $pass, $base);
$laBase->connexion();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Consult hours</title>
		<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
        <link rel="stylesheet" href="Styles/style.css?ver=1.0" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

		<script>
		$(document).ready(function() {
		$('#table').DataTable();
		} );
		</script>

    </head>
    <body>

        <?php
$sql = "SELECT nickname FROM user";
$result = $laBase->requete($sql);
echo "<form action='' method='post' id='form'>";
echo "You are : ";
echo "<select id=\"nickname\" name=\"nickname\">";

foreach($result as $unResult)
	{
	echo '<option value="' . $unResult[0] . '"';
	echo '>' . $unResult[0] . '</option>';
	}

echo "<input type=\"submit\" name=\"submit\" value=\"View the available hours for the members of Team Avatar in your timezone!\" />";
echo "</select>";
echo "</form>";
echo "<br />";
?>

        <script>
  $(document).ready(function() {
    <?php
session_start(); ?>
    if (<?php
echo isset($_SESSION['nickname']) ? 'true' : 'false'; ?>) {

        $(document).ready(function(){
        $('select[name="nickname"]').first().val("<?php
echo $_SESSION['nickname']; ?>");
        })
    }
  });
</script>

            <?php

if (isset($_POST['submit']) || (isset($_SESSION['nickname'])))
	{
	if (isset($_POST['submit']))
		{
		$_SESSION['nickname'] = $_POST['nickname'];
		}

	$nickname = $_SESSION['nickname'];
	$you = "SELECT user.nickname, UTC, start.monday, start.tuesday, start.wednesday, start.thursday, start.friday, start.saturday, start.sunday, end.monday, end.tuesday, end.wednesday, end.thursday, end.friday, end.saturday, end.sunday ";
	$you.= "FROM user INNER JOIN start ON user.nickname = start.nickname ";
	$you.= "INNER JOIN end ON start.nickname = end.nickname ";
	$you.= "WHERE user.nickname='" . $nickname . "'";
	$youResult = $laBase->requete($you);
	$yourStartMonday = $youResult[0][2];
	$yourStartTuesday = $youResult[0][3];
	$yourStartWednesday = $youResult[0][4];
	$yourStartThursday = $youResult[0][5];
	$yourStartFriday = $youResult[0][6];
	$yourStartSaturday = $youResult[0][7];
	$yourStartSunday = $youResult[0][8];
	$YourEndMonday = $youResult[0][9];
	$YourEndTuesday = $youResult[0][10];
	$YourEndWednesday = $youResult[0][11];
	$YourEndThursday = $youResult[0][12];
	$YourEndFriday = $youResult[0][13];
	$YourEndSaturday = $youResult[0][14];
	$YourEndSunday = $youResult[0][15];
	$YourTZ = $youResult[0][1];	
	
	$sql = "SELECT user.nickname, UTC, start.monday, start.tuesday, start.wednesday, start.thursday, start.friday, start.saturday, start.sunday, end.monday, end.tuesday, end.wednesday, end.thursday, end.friday, end.saturday, end.sunday ";
	$sql.= "FROM user INNER JOIN start ON user.nickname = start.nickname ";
	$sql.= "INNER JOIN end ON start.nickname = end.nickname ";
	$sql.= "WHERE user.nickname <> '" . $nickname . "'";
	$result = $laBase->requete($sql);

	echo "<table id=\"table\" class=\"display\">";
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nickname</th>';
	echo '<th>Monday</th>';
	echo '<th>Tuesday</th>';
	echo '<th>Wednesday</th>';
	echo '<th>Thursday</th>';
	echo '<th>Friday</th>';
	echo '<th>Saturday</th>';
	echo '<th>Sunday</th>';
	echo '<th></th>';
	echo '<th></th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	foreach($youResult as $unYouResult)
		{
		echo '<tr>';
		echo "<td style=\"text-align:center;\"> $nickname </td>";
		echo "<td style=\"text-align:center;\"> $yourStartMonday - $YourEndMonday </td>";
		echo "<td style=\"text-align:center;\"> $yourStartTuesday - $YourEndTuesday </td>";
		echo "<td style=\"text-align:center;\"> $yourStartWednesday - $YourEndWednesday </td>";
		echo "<td style=\"text-align:center;\"> $yourStartThursday - $YourEndThursday </td>";
		echo "<td style=\"text-align:center;\"> $yourStartFriday - $YourEndFriday </td>";
		echo "<td style=\"text-align:center;\"> $yourStartSaturday - $YourEndSaturday </td>";
		echo "<td style=\"text-align:center;\"> $yourStartSunday - $YourEndSunday </td>";
		echo '<td style="text-align:center"><a href="modifTime.php?nickname=' . $unYouResult[0] . '" class="btnAction">modify</a></td>';
		echo '<td style="text-align:center"><a href="deleteTime.php?nickname=' . $unYouResult[0] . '" onclick="return(confirm(\'Are you sure you want to delete this entry?\'))" class="btnAction">delete</a></td>';
		echo '</tr>';
		}

	foreach($result as $unResult)
		{
		$PepTZ = $unResult[1];
		$startMonday = date_create($unResult[2], timezone_open($PepTZ));
		$startMonday = date_timezone_set($startMonday, timezone_open($YourTZ));
		$startMonday = date_format($startMonday, 'H:i:s');
		$startTuesday = date_create($unResult[3], timezone_open($PepTZ));
		$startTuesday = date_timezone_set($startTuesday, timezone_open($YourTZ));
		$startTuesday = date_format($startTuesday, 'H:i:s');
		$startWednesday = date_create($unResult[4], timezone_open($PepTZ));
		$startWednesday = date_timezone_set($startWednesday, timezone_open($YourTZ));
		$startWednesday = date_format($startWednesday, 'H:i:s');
		$startThursday = date_create($unResult[5], timezone_open($PepTZ));
		$startThursday = date_timezone_set($startThursday, timezone_open($YourTZ));
		$startThursday = date_format($startThursday, 'H:i:s');
		$startFriday = date_create($unResult[6], timezone_open($PepTZ));
		$startFriday = date_timezone_set($startFriday, timezone_open($YourTZ));
		$startFriday = date_format($startFriday, 'H:i:s');
		$startSaturday = date_create($unResult[7], timezone_open($PepTZ));
		$startSaturday = date_timezone_set($startSaturday, timezone_open($YourTZ));
		$startSaturday = date_format($startSaturday, 'H:i:s');
		$startSunday = date_create($unResult[8], timezone_open($PepTZ));
		$startSunday = date_timezone_set($startSunday, timezone_open($YourTZ));
		$startSunday = date_format($startSunday, 'H:i:s');
		$endMonday = date_create($unResult[9], timezone_open($PepTZ));
		$endMonday = date_timezone_set($endMonday, timezone_open($YourTZ));
		$endMonday = date_format($endMonday, 'H:i:s');
		$endTuesday = date_create($unResult[10], timezone_open($PepTZ));
		$endTuesday = date_timezone_set($endTuesday, timezone_open($YourTZ));
		$endTuesday = date_format($endTuesday, 'H:i:s');
		$endWednesday = date_create($unResult[11], timezone_open($PepTZ));
		$endWednesday = date_timezone_set($endWednesday, timezone_open($YourTZ));
		$endWednesday = date_format($endWednesday, 'H:i:s');
		$endThursday = date_create($unResult[12], timezone_open($PepTZ));
		$endThursday = date_timezone_set($endThursday, timezone_open($YourTZ));
		$endThursday = date_format($endThursday, 'H:i:s');
		$endFriday = date_create($unResult[13], timezone_open($PepTZ));
		$endFriday = date_timezone_set($endFriday, timezone_open($YourTZ));
		$endFriday = date_format($endFriday, 'H:i:s');
		$endSaturday = date_create($unResult[14], timezone_open($PepTZ));
		$endSaturday = date_timezone_set($endSaturday, timezone_open($YourTZ));
		$endSaturday = date_format($endSaturday, 'H:i:s');
		$endSunday = date_create($unResult[15], timezone_open($PepTZ));
		$endSunday = date_timezone_set($endSunday, timezone_open($YourTZ));
		$endSunday = date_format($endSunday, 'H:i:s');
	
		echo '<tr>';
		echo "<td style=\"text-align:center;\"> $unResult[0] </td>";
		echo "<td style=\"text-align:center;\"> $startMonday - $endMonday </td>";
		echo "<td style=\"text-align:center;\"> $startTuesday - $endTuesday </td>";
		echo "<td style=\"text-align:center;\"> $startWednesday - $endWednesday </td>";
		echo "<td style=\"text-align:center;\"> $startThursday - $endThursday </td>";
		echo "<td style=\"text-align:center;\"> $startFriday - $endFriday </td>";
		echo "<td style=\"text-align:center;\"> $startSaturday - $endSaturday </td>";
		echo "<td style=\"text-align:center;\"> $startSunday - $endSunday </td>";
		echo '<td style="text-align:center"><a href="modifTime.php?nickname=' . $unResult[0] . '" class="btnAction">modify</a></td>';
		echo '<td style="text-align:center"><a href="deleteTime.php?nickname=' . $unResult[0] . '" onclick="return(confirm(\'Are you sure you want to delete this entry?\'))" class="btnAction">delete</a></td>';
		echo '</tr>';
                
		}
	}
?>
    </body>
</html>