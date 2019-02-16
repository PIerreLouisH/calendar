<?php
header('content-type: text/html; charset=utf-8');
require ("laBDD.php");

require ("Parametres.php");

$laBase = new laBDD($hote, $user, $pass, $base);
$laBase->connexion();

if (!isset($_SESSION))
	{
	session_start();
	}

?>


<html>
   <head>
      <meta content="text/html; charset=utf-8" http-equiv="content-type">
      <title>Add your hours</title>
      <link rel="stylesheet" href="Styles/style.css?ver=1.0" type="text/css" />
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.6/jstz.min.js"></script>
      <script type="text/javascript">
         var timezone = jstz.determine();
         //jstz is a Javascript Jquery Library which allow to auto-detect the user timezone and store it as IANA timezone.
         //This script does not do geo-location, nor does it care very much abouthistorical time zones.  
         //For example, "Europe/Berlin" can be stored as "Europe/Stockholm" since it's the same timezone.
         //That's a good way to show yours users you don't want to exploit their data (IP, timezones...) if you only means to convert time without asking them.
      </script>
   </head>
   
   <form action='' method='post' class='form-style-10'>
      <h1>Add your Available Hours</h1>
      <h4>The site will determine your timezone, simply put in the hours you are normally available during for each day of the week, in a 24 hour format (1:00 is 1 am, 13:00 is 1 pm).</h4>
      <input id="utc" type="hidden" name="utc" value="" />
      <script type="text/javascript">
         document.getElementById('utc').value = timezone.name();
      </script>
      <input type="text" id="nickname" name="nickname" placeholder="Your Nickname" required>
      <br />
      <fieldset>
         <legend>Monday</legend>
         <div class="start">
            <input type="time" id="start-monday" name="start-monday" required> 
            <input type="time" id="end-monday" name="end-monday" required>
         </div>
      </fieldset>
      <br />
      <fieldset>
         <legend>Tuesday</legend>
         <div class="start">
            <input type="time" id="start-tuesday" name="start-tuesday" required>
            <input type="time" id="end-tuesday" name="end-tuesday" required>
         </div>
      </fieldset>
      <br />
      <fieldset>
         <legend>Wednesday</legend>
         <div class="start">
            <input type="time" id="start-wednesday" name="start-wednesday" required>
            <input type="time" id="end-wednesday" name="end-wednesday" required>
         </div>
      </fieldset>
      <br />
      <fieldset>
         <legend>Thursday</legend>
         <div class="start">
            <input type="time" id="start-thursday" name="start-thursday" required>
            <input type="time" id="end-thursday" name="end-thursday" required>
         </div>
      </fieldset>
      <br />
      <fieldset>
         <legend>Friday</legend>
         <div class="start">
            <input type="time" id="start-friday" name="start-friday" required>
            <input type="time" id="end-friday" name="end-friday" required>
         </div>
      </fieldset>
      <br />
      <fieldset>
         <legend>Saturday</legend>
         <div class="start">
            <input type="time" id="start-saturday" name="start-saturday" required>
            <input type="time" id="end-saturday" name="end-saturday" required>
         </div>
      </fieldset>
      <br />
      <fieldset>
         <legend>Sunday</legend>
         <div class="start">
            <input type="time" id="start-sunday" name="start-sunday" required>
            <input type="time" id="end-sunday" name="end-sunday" required>
         </div>
      </fieldset>
      <br />
      <input type="submit" name="submit" value="Create" />
   </form>
   <br />
   </form>
</html>		

<?php

if (isset($_POST['submit']))
	{
	$nickname = $_POST['nickname'];
	$utc = $_POST['utc'];
	$sql = "INSERT INTO user (nickname,UTC) VALUES ('$nickname', '$utc'); ";

	$result = $laBase->requete($sql);
	$startmonday = $_POST['start-monday'];
	$starttuesday = $_POST['start-tuesday'];
	$startwednesday = $_POST['start-wednesday'];
	$startthursday = $_POST['start-thursday'];
	$startfriday = $_POST['start-friday'];
	$startsaturday = $_POST['start-saturday'];
	$startsunday = $_POST['start-sunday'];
	$sql = "INSERT INTO start (nickname, monday,tuesday,wednesday,thursday,friday,saturday,sunday) VALUES ('$nickname', '$startmonday', '$starttuesday', '$startwednesday', '$startthursday', '$startfriday', '$startsaturday', '$startsunday'); ";

	$result = $laBase->requete($sql);
	$endmonday = $_POST['end-monday'];
	$endtuesday = $_POST['end-tuesday'];
	$endwednesday = $_POST['end-wednesday'];
	$endthursday = $_POST['end-thursday'];
	$endfriday = $_POST['end-friday'];
	$endsaturday = $_POST['end-saturday'];
	$endsunday = $_POST['end-sunday'];
	$sql = "INSERT INTO end (nickname, monday,tuesday,wednesday,thursday,friday,saturday,sunday) VALUES ('$nickname', '$endmonday', '$endtuesday', '$endwednesday', '$endthursday', '$endfriday', '$endsaturday', '$endsunday'); ";

	$_SESSION['nickname'] = $nickname;

	$result = $laBase->requete($sql);
	header("Location: index.php");
	}

?>