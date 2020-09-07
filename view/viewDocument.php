<!doctype html>
<html lang="fr">
<head>
	<title>Edit Document</title>
	<meta charset="UTF-8">
</head>

<body>

<?php echo "<h1 class='title'>".$_SESSION['doc']."</h1>" ?>

<div id="main">
	<?php
		foreach ($result as $entry) {
			$doc=array();
		    foreach($entry as $x => $x_value) {
		 		if(gettype($x_value)=='object' and get_class($x_value)=='MongoDB\BSON\ObjectId'){
		 			$value = $x_value;
		 		}
		 		elseif(gettype($x_value)=='object' and get_class($x_value)=='MongoDB\BSON\UTCDateTime'){
		 			$value = $x_value->toDateTime();
		 		}
		 		else{
		 	  		$value = printable($x_value);
		 		}
		 		$doc[$x] = improved_var_export($value);
		 	}
		 		$doc = init_json($doc);
		 		$docs = stripslashes(json_encode($doc,JSON_PRETTY_PRINT));
	 	}
	 	echo '<textarea name="doc_text" id="doc_text" rows="20" cols="200" readonly="readonly" required>'.$docs.'</textarea>';
	 	echo '<br>';
	 	if(isset($_GET['search'])){
	 		echo '<a href="index.php?action=getCollection_search&page='.$_GET['search'].'">< Collection</a>';
	 	}
	 	else{
	 		echo '<a href="index.php?action=getCollection&coll_id='.$_SESSION['collection'].'">< Collection</a>';
	 	}
	?>
</div>

</body>
</html>