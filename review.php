<?php
session_start();
extract($_POST);
extract($_SESSION);
error_reporting(1);
include("database.php");
if($submit=='Finish')
{
	mysql_query("delete from mst_useranswer where sess_id='" . session_id() ."'") or die(mysql_error());
	unset($_SESSION[qn]);
	header("Location: index.php");
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Online Quiz - Review Quiz </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="quiz.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
include("header.php");
echo "<h1 class=head1> Review Test Question</h1>";

if(!isset($_SESSION[qn]))
{
		$_SESSION[qn]=0;
}
else if($submit=='Next Question' )
{
	$_SESSION[qn]=$_SESSION[qn]+1;
	
}

$rs=mysql_query("select * from mst_useranswer where sess_id='" . session_id() ."'",$cn) or die(mysql_error());
mysql_data_seek($rs,$_SESSION[qn]);
$row= mysql_fetch_row($rs);
echo "<br><br><div style='margin:auto; width:60%; text-align:center;box-shadow:2px 3px 2px 3px #CCCCCC; border-radius:10px ;text-align:left'>";
echo "<form name=myfm method=post action=review.php>";
echo "<table align='center'> <tr> <td width=30>&nbsp;<td> <table border=0>";
$n=$_SESSION[qn]+1;
echo "<tr align='center'><td><span class=style2>Question ".  $n .": $row[2]</style><hr>";
echo "<tr align='center'><td class=".($row[7]==1?'tans':'style8').">$row[3]";
echo "<tr align='center'><td class=".($row[7]==2?'tans':'style8').">$row[4]";
echo "<tr align='center'><td class=".($row[7]==3?'tans':'style8').">$row[5]";
echo "<tr align='center'><td class=".($row[7]==4?'tans':'style8').">$row[6]<br><hr>";
if($_SESSION[qn]<mysql_num_rows($rs)-1)
echo "<tr><td colspan=2 align=center class='errors'><input class='errors' style='background-color:blue; background-size:auto; color:white; border:#0000FF' type=submit name=submit value='Next Question'></form>";
else
echo "<tr><td colspan=2 align=center class='errors'><input class='errors' style='background-color:blue; background-size:auto; color:white; border:#0000FF' type=submit name=submit value='Finish'></form></div>";

echo "</table></table>";
?>
