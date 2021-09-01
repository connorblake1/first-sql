<!DOCTYPE html>
<html>
<head>
<title>Edit and Delete</title>
<meta name="author" content="Connor Blake" >
<style type="text/css">
	h1 {font-size: 36pt; font-weight: bold;text-align: center;}
</style>
</head>
<body>
<h1>Edit Table Entries</h1>
<?php
	require("../db1_connector.php");
	if (isset($_REQUEST['selection'])) {
		$command = $_REQUEST['command'];
		$id = $_REQUEST['selection'];
		$query = "select * from mathseq_ser where name_id = $id ;";
		$query_result = mysqli_query($db_connection,$query);
		$row = mysqli_fetch_array($query_result);
		$name = $row['name'];
		$typeBool = $row['type'];
		$subTypeBool = $row['cvg_avg'];
		$term1 = $row['term1'];
		$term2 = $row['term2'];
		$term3 = $row['term3'];
		if($command == 'Delete') {
			echo("<form method = 'get' action='Sequences_Series.php'>\n");
			echo("Are you sure you want to delete $name?\n");
			echo("<input type='hidden' name='deleteID' value=$id>\n");
			echo("<input type='submit' name ='command' value= 'Cancel'>\n
						<input type ='submit' name='command' value='Permanently delete'>\n");
			echo("</form>");}
elseif ($command == 'Change') {
			echo("<form method = 'get' action='Sequences_Series.php'>\n");
			echo("<input type='hidden' name='changeID' value=$id>\n");
			echo("<table><tr><td>Name</td><td><input type='text' name='name' value='$name'/></td></tr>\n");
			if ($typeBool == 1) {
				$typeString = 'Sequence';}
			elseif($typeBool == 0) {
				$typeString = 'Series';}
			if($typeBool == 0 && $subTypeBool == 1) {
				$subTypeString = 'Convergent';}
			elseif($typeBool == 0 && $subTypeBool == 0) {
				$subTypeString = 'Divergent';}
			elseif ($typeBool == 1) {
				$subTypeString = 'N/A';}
			
			echo("<tr><td>Type</td><td>");
			$types = array ('Sequence','Series');
			echo ("<select name='type'>");
				foreach ($types as $t){
     				echo("<option value='$t'");
    				if ($t == $typeString){
        				echo("selected");}
     				echo(">$t</option>");}
			echo ("</select>");
			echo("<br />");
			echo("</td></tr>\n");
			
			echo("<tr><td>Sub Type</td><td>");
			$subtypes = array ('Convergent','Divergent','N/A');
			echo ("<select name='typetype'>");
				foreach ($subtypes as $tt){
     				echo("<option value='$tt'");
    				if ($tt == $subTypeString){
        				echo("selected");}
     				echo(">$tt</option>");}
			echo ("</select>");
			echo("</td></tr>\n");
			
			
			echo("<tr><td>Term 1</td><td><input type=text name='term1' value='$term1'/></td></tr>\n");
			echo("<tr><td>Term 2</td><td><input type=text name='term2' value='$term2'/></td></tr>\n");
			echo("<tr><td>Term 3</td><td><input type=text name='term3' value='$term3'/></td></tr>\n");
			echo("</table>\n");
			echo("<input type='submit' name='command' value='Cancel' />\n");
			echo("<input type='submit' name='command' value='Edit this'/>\n");
			echo("</form>\n");}}
	
	else {
	echo("Nothing has been selected - select an entry to edit or delete<br />
				<a href='Sequences_Series.php'>Go back</a>\n");}
?>
</body>
</html>