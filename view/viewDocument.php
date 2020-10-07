<!doctype html>
<html lang="fr">
<head>
	<?php echo '<title>View'.$_GET['doc'].'</title>'; ?>

	<meta charset="UTF-8">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="public/css/breadcrumb.css" rel="stylesheet" type="text/css">
	<link href="public/css/viewDocument.css" rel="stylesheet" type="text/css">
	<link href="public/css/titre.css" rel="stylesheet" type="text/css">
	<link href="public/css/btn_return.css" rel="stylesheet" type="text/css">
	<script src="public/js/db.js"></script>
</head>

<body>

<?php

//Fil d'Ariane

echo "<div class='container  col-lg-8 sticky-top'  style='margin-left: 100px;'>";
	echo '<ol class="breadcrumb">';
		echo '<li class="breadcrumb-item"><a href="index.php?"><i class="fa fa-fw fa-home"></i>Home</a></li>';
		if(isset($_GET['serve'])){
			if($_GET['action']=='getServer'){
				echo '<li class="breadcrumb-item active">'.$_GET['serve'].'</li>';
			}
			else{
				echo '<li class="breadcrumb-item"><a href="index.php?action=getServer&serve='.$_GET['serve'].'"><i class="fa fa-fw fa-desktop"></i> '.$_GET['serve'].'</a></li>';
			}
		}
		if(isset($_GET['db'])){
			if($_GET['action']=='getDb'){
				echo '<li class="breadcrumb-item active"><i class="fa fa-fw fa-database"></i>'.$_GET['db'].'</li>';
			}
			else{
				echo '<li class="breadcrumb-item"><a href="index.php?action=getDb&serve='.$_GET['serve'].'&db='.$_GET['db'].'"><i class="fa fa-fw fa-database"></i>'.$_GET['db'].'</a></li>';
			}
		}
		if(isset($_GET['coll'])){
			if($_GET['action']=='getCollection' or $_GET['action']=='getCollection_search'){
				echo '<li class="breadcrumb-item active"><i class="fa fa-fw fa-server"></i>'.$_GET['coll'].'</li>';
			}
			else{
				echo '<li class="breadcrumb-item"><a href="index.php?action=getCollection&serve='.$_GET['serve'].'&db='.$_GET['db'].'&coll='.$_GET['coll'].'"><i class="fa fa-fw fa-server"></i>'.$_GET['coll'].'</a></li>';
			}
		}
		if(isset($_GET['doc'])){
			echo '<li class="breadcrumb-item active"><i class="icon-book"></i>'.$_GET['doc'].'</li>';
		}
	echo '</ol>';
echo '</div>';

//Fin fil d'Ariane


//Titre de la page

echo "<h1 class='title text-center '>View <i class='fa fa-fw fa-book'></i>".$_GET['doc']."</h1>";

//Fin du titre de la page


//Barre de boutons

echo '<div id="nav_view">';

//Bouton de retour

if(isset($_GET['s_g'])){
	echo '<a href="index.php?action=getCollection_search&serve='.$_GET['serve'].'&db='.$_GET['db'].'&coll='.$_GET['coll'].'&s_g='.$_GET['s_g'].'&page='.$_GET['page'].'"><button class="return btn btn-primary">< Collection</button></a>';
}
elseif(isset($_GET['a_s'])){
	echo '<a href="index.php?action=advancedSearch&serve='.$_GET['serve'].'&db='.$_GET['db'].'&coll='.$_GET['coll'].'&a_s='.urlencode($_GET['a_s']).'&page='.$_GET['page'].'"><button class="return btn btn-primary">< Collection</button></a>';
}
elseif(isset($_GET['search_db'])){
	echo '<a href="index.php?action=getDb_search&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&search_db='.strip_tags($_GET['search_db']).'"><button class="return btn btn-primary">< Collection</button></a>';
}
else{
	echo '<a href="index.php?action=getCollection&serve='.$_GET['serve'].'&db='.$_GET['db'].'&coll='.$_GET['coll'].'&page='.$_GET['page'].'"><button class="return btn btn-primary">< Collection</button></a>';
}

//Fin du bouton de retour


//Bouton Edit

$link_d = 'index.php?action=deleteDocument&serve='.$_GET['serve'].'&db='.$_GET['db'].'&coll='.$_GET['coll'].'&doc='.$_GET['doc'].'&page='.$_GET['page'];

$link_edit = 'index.php?action=editDocument&serve='.$_GET['serve'].'&db='.$_GET['db'].'&coll='.$_GET['coll'].'&doc='.$_GET['doc'].'&page='.$_GET['page'];

if(isset($_GET['type_id'])){
	$link_edit=$link_edit.'&type_id='.$_GET['type_id'];
	$link_d=$link_d.'&type_id='.$_GET['type_id'];
}
if(isset($_GET['s_s'])){
	$link_edit=$link_edit.'&s_s='.$_GET['s_s'];
	$link_d=$link_d.'&s_s='.$_GET['s_s'];
}
if(isset($_GET['s_g'])){
	$link_edit=$link_edit.'&s_g='.$_GET['s_g'];
	$link_d=$link_d.'&s_g='.$_GET['s_g'];
}
$link_edit=$link_edit.'&page='.$_GET['page'];
$link_d=$link_d.'&page='.$_GET['page'];

echo '<div class=" text-center  m-auto py-2"><a href="'.$link_edit.'"><button class="btn btn-success font-weight-bold">Edit</button></a>
    <button  class="btn btn-danger "><a class="text-light font-weight-bold" href="'.$link_d.'" onclick="return confirmDelete()">Delete</a></button>

</div>';



//Fin du bouton Edit

echo '</div>';

//Fin de la barre de boutons

?>

<!-- Zone de document -->

<div id="main">
	<?php

		//Formatage du document en JSON

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
		 		$temp =  improved_var_export($value);
	 	  		$doc[$x] = getColor($temp);
		 	}
		 	$doc = init_json($doc);
			$docs = stripslashes(json_encode($doc,JSON_PRETTY_PRINT));
	 	}

	 	//Affichage du document

	 	echo '<pre name="doc_text" id="doc_text">'.$docs.'</pre>';
	 	echo '<br>';
	?>
</div>

<!-- Fin de la zone de document -->

</body>
</html>