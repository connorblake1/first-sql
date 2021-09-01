<!DOCTYPE html>
<html>
<head>
<title>Sequences and Series</title>
<meta name="author" content="Connor Blake" >
<style type="text/css">
table {border: 1px solid black;}
</style>
</head>
<body>
<?php
	require("../db1_connector.php");
	
if (isset($_REQUEST['command'])){
   $command = $_REQUEST['command'];}
else{
	$command = "none";}
if ($command == "Add") {
	$addTitle = $_REQUEST['addTitle'];
	$addType = $_REQUEST['addType'];
	$addTypeType = $_REQUEST['addTypeType'];
	$addTerm1 = $_REQUEST['addTerm1'];
	$addTerm2 = $_REQUEST['addTerm2'];
	$addTerm3 = $_REQUEST['addTerm3'];	

	$addCommand = "INSERT INTO mathseq_ser (name,type,cvg_avg,term1,term2,term3) VALUES
	               ('$addTitle','$addType','$addTypeType','$addTerm1','$addTerm2','$addTerm3');";
	$addReturn = mysqli_query($db_connection,$addCommand);
	
	if ($addReturn == true){
		echo("Added.<br />\n");}}
elseif($command == "Permanently delete") {
	$deleteID = $_REQUEST['deleteID'];
	$deleteCommand = "delete from mathseq_ser where name_id = $deleteID ;";
	$deleteReturn = mysqli_query($db_connection,$deleteCommand);
	if ($deleteReturn == true) {
		echo("Poof, it's gone.<br />\n");}}
elseif($command == "Edit this") {
	$id = $_REQUEST['changeID'];
	$changeName = $_REQUEST['name'];
	$changeTypeString = $_REQUEST['type'];
	$changeTypeTypeString = $_REQUEST['typetype'];
	if ($changeTypeString == 'Sequence') {
		$changeTypeBool = 1;}
	elseif($changeTypeString == 'Series') {
		$changeTypeBool = 0;}
	if ($changeTypeTypeString == 'N/A' || $changeTypeTypeString == 'Divergent') {
		$changeTypeTypeBool = 0;}
	elseif($changeTypeTypeString == 'Convergent') {
		$changeTypeTypeBool = 1;}
	$changeT1 = $_REQUEST['term1'];
	$changeT2 = $_REQUEST['term2'];
	$changeT3 = $_REQUEST['term3'];
	$changeCommand = "update mathseq_ser set name = '$changeName', type='$changeTypeBool', cvg_avg='$changeTypeTypeBool', term1='$changeT1', term2='$changeT2', term3='$changeT3' where name_id = $id ;";
	$changeReturn	= mysqli_query($db_connection,$changeCommand);
	if ($changeReturn == true) {
		echo("Entry changed.<br />\n");}}
	
	if (isset($_REQUEST['sort'])) {
		$sort = $_REQUEST['sort'];
		if($sort == 'Sort by Name') {
			$sortCommand = "SELECT * FROM mathseq_ser ORDER BY name;";}
		elseif($sort == 'Sort by Type') {
			$sortCommand = "SELECT * FROM mathseq_ser ORDER BY type;";}
		elseif($sort == 'Sort by Sub Type') {
			$sortCommand = "SELECT * FROM mathseq_ser ORDER BY cvg_avg;";}
}
	else {
		$sortCommand = "SELECT * FROM mathseq_ser;";}
	
	$query_result = mysqli_query($db_connection,$sortCommand);
	echo ("<form method = 'get' action = 'edit_delete.php'>\n");
	echo("<table><tr><th>Select</th><th>Name</th><th>Type</th><th>Convergent or Divergent</th><th>Term 1</th><th>Term 2</th><th>Term 3</th><th>First three terms</th></tr>\n");
	while ($row = mysqli_fetch_array($query_result)){
		$id = $row['name_id'];
		$name = $row['name'];
		$type = $row['type'];
		$cvg = $row['cvg_avg'];
		$term1 = $row['term1'];
		$term2 = $row['term2'];
		$term3 = $row['term3'];
		if ($type == 1) {
			$color = "lightblue";}
		elseif($type == 0) {
			$color = "lightgreen";}
		echo("<tr style=\"background-color:$color\"><td><input type='radio' name='selection' value = '$id'></td><td><b>$name</b></td><td>");
		
		if ($type == 0){
			echo("<b>Series</b>");}
		elseif($type == 1) {
			echo("<b>Sequence</b>");}
		echo("</td><td>");
		
		if ($type == 0 && $cvg == 1){
			echo("<b>Convergent</b>");}
		elseif($type == 0 && $cvg == 0) {
			echo("<b>Divergent</b>");}
		elseif($type == 1) {
			echo("<b>N/A</b>");}
		
		echo("</td><td>$term1</td><td>$term2</td><td>$term3</td><td><h1>");
		
		if ($type == 1){
			$p = ', ';}
		elseif($type == 0) {
			$p = ' + ';}
		$concatenator = "$term1$p$term2$p$term3$p ...";
		
		
		echo("$concatenator</h1></td></tr>\n");}
		
	echo("</table>\n");
	
	echo("<a href=\"AddSeqSer.html\">Add Entry</a>\n");
	echo("<br />");
	echo("<input type='submit' name='command' value='Delete'><br />\n");
	echo("<input type='submit' name='command' value='Change'><br />\n");
	echo("</form>");
	echo("<form method='get' action='Sequences_Series.php'>\n");
	echo("<input type='submit' name='sort' value='Sort by Name'><br />\n");
	echo("<input type='submit' name='sort' value='Sort by Type'><br />\n");
	echo("<input type='submit' name='sort' value='Sort by Sub Type'><br />\n");
	echo("</form>\n");
	
?>
</body>
</html>