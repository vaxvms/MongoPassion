<?php

    require('model/model.php');

    function editDocument()
    {
	    $result = getDocument();
	    $link_doc = getLink_doc();
	    require('view/editDocument.php');
    }

    function traitement_uD()
    {
    	$error_id = searchError_doc_id();
    	if($error_id==true){
			echo "<script>alert(\"Le champ '_id' n'est pas modifiable\");document.location.href = 'index.php?action=getCollection';</script>";
    	}
    	else{
	    	$update = getUpdate_doc();
	    	$id = getDoc_id();
	    	updateDoc($id,$update);

	    	if(isset($_GET['search'])){
                header('Location: index.php?action=getCollection_search&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&coll='.strip_tags($_GET['coll']).'&s_id='.strip_tags($_GET['s_id']).'&s_g='.strip_tags($_GET['s_g']).'&page='.strip_tags($_GET['page']).'');
            }
            else{
                header('Location: index.php?action=getCollection&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&coll='.strip_tags($_GET['coll']).'&page='.strip_tags($_GET['page']).'');
            }
	    }
    }

    function getCollection()
    {
    	try{
            if(isset($_GET['coll']))
        	$coll=strip_tags($_GET['coll']);

        	else{
        		header('Location: index.php?action=error');
        	}

        	$bypage = 50;
        	$nbDocs = countDocs();
        	$nbPages = getNbPages($nbDocs,$bypage);

        	if(isset($_GET['page'])){
        		$page = strip_tags($_GET['page']);
        	}
        	else{
        		$page = 1;
        	}

    	    $docs = getDocs($page,$bypage);

        	require('view/getCollection.php');
        }
        catch(Exception $e){
            echo $e;
        }
    }

    function createDocument()
    {
    	require('view/createDocument.php');
    }

    function traitement_nD()
    {
        try{
        	$doc = getNew_doc();
        	insertDoc($doc);
        	header('Location: index.php?action=getCollection&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&coll='.strip_tags($_GET['coll']).'');
        }
        catch(Exception $e){
            echo $e;
        }
    }

    function deleteDocument()
    {
    	deleteDoc();
    	if(isset($_GET['search'])){
            header('Location: index.php?action=getCollection_search&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&coll='.strip_tags($_GET['coll']).'&s_id='.strip_tags($_GET['s_id']).'&s_g='.strip_tags($_GET['s_g']).'&page='.strip_tags($_GET['search']).'');
        }
        else{
            header('Location: index.php?action=getCollection&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&coll='.strip_tags($_GET['coll']).'&page='.strip_tags($_GET['page']).'');
        }
    }

    function viewDocument()
    {
    	try{
            $result = getDocument();
            require('view/viewDocument.php');
        }
        catch(Exception $e){
            echo "<script>alert(\"Le serveur n'autorise pas la connexion\");document.location.href = 'index.php';</script>";
        }
    }

    function getCollection_search()
    {
        try{
        	$bypage = 50;

        	if(isset($_POST['special_search'])){
                if(isset($_GET['page'])){
                    $page = strip_tags($_GET['page']);
                }
                else{
                    $page = 1;
                }
                $docs = getSpecialSearch(strip_tags($_POST['special_search']),$page,$bypage);
                $nbDocs = countSpecialSearch(strip_tags($_POST['special_search']));

            }
            elseif (isset($_GET['s_s'])) {
                if(isset($_GET['page'])){
                    $page = strip_tags($_GET['page']);
                }
                else{
                    $page = 1;
                }
                $search = strip_tags(urldecode($_GET['s_s']));
                $docs = getSpecialSearch($search,$page,$bypage);
                $nbDocs = countSpecialSearch($search);
            }
            else
            {
                if(isset($_GET['page'])){
                    $page = strip_tags($_GET['page']);
                    $recherche_id = strip_tags($_GET['s_id']);
                    $recherche_g = strip_tags(urldecode($_GET['s_g']));
                }
                else{
                    $page = 1;
                    $recherche_id = strip_tags($_POST['recherche_id']);
                    $recherche_g = strip_tags($_POST['recherche_g']);
                }
            
                if(isset($recherche_id) and isset($recherche_g)){
                    if($recherche_id=="" and $recherche_g=="field : content[...]"){
                        header('Location: index.php?action=getCollection&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&coll='.strip_tags($_GET['coll']).'');
                    }
                    else{
                        $docs = getSearch($recherche_id,$recherche_g,$page,$bypage);
                    }
                }
                else{
                    $docs = getDocs($page,$bypage);
                }
                $nbDocs = countSearch($recherche_id,$recherche_g);
            }

        	$nbPages = getNbPages($nbDocs,$bypage);

        	require('view/getCollection_search.php');
        }
        catch(Exception $e){
            echo $e;
        }
    }

    function renameCollection()
    {
        try{
            $newname = str_replace(' ', '_', strip_tags($_POST['newname']));
            renameCollec($newname);
            header('Location: index.php?action=editCollection&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'&coll='.$newname.'');
        }
        catch(Exception $e){
            echo "<script>alert(\"Le nouveau nom est identique à l'ancien\");document.location.href = 'index.php?action=getDb&db_id=".strip_tags($_GET['db'])."';</script>";
        }
    }

    function editCollection()
    {
        require('view/editCollection.php');
    }

    function createCollection()
    {
        try{
            $newname = str_replace(' ', '_', strip_tags($_POST['name']));
            createCollec($newname);
            header('Location: index.php?action=getDb&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'');
        }
        catch(Exception $e){
            echo "<script>alert(\"Cette collection existe déjà\");document.location.href = 'index.php?action=getDb&serve=".strip_tags($_GET['serve'])."&db=".strip_tags($_GET['db'])."';</script>";
            echo $e;
        }
    }

    function deleteCollection()
    {
        deleteColl();
        header('Location: index.php?action=getDb&serve='.strip_tags($_GET['serve']).'&db='.strip_tags($_GET['db']).'');
    }

    function moveCollection()
    {
        $db = strip_tags($_POST['newdb']);
        moveCollec($db);
        header('Location: index.php?action=getDb&serve='.strip_tags($_GET['serve']).'&db='strip_tags(.$_GET['db']).'');
    }

    function getDb()
    {
    	if(isset($_GET['db']))
    	$db=strip_tags($_GET['db']);

    	else{
    		header('Location: index.php?action=error');
    	}
    	$collections = getCollections($db);
    	require('view/getDb.php');
    }

    function error()
    {
    	require('view/error.php');
    }

    function getServer()
    {
        $serve_list=json_decode($_COOKIE['serve_list']);
    	try{
            if(isset($_GET['serve'])){
        		$serve=strip_tags($_GET['serve']);
        	}
        	elseif(isset($_POST['serve'])){
        		$serve=strip_tags($_POST['serve']);
        		if(!in_array(strip_tags($_POST['serve']), $serve_list)){
        			array_push($serve_list, $serve);
                    setcookie('serve_list',json_encode($serve_list));
        		}
        	}
        	elseif(!isset($_SESSION['serve'])){
        		header('Location: index.php?action=error');
        	}
        	$dbs = getDbs($serve);
        	require('view/getServer.php');
        }
        catch(Exception $e){
            if (($key = array_search(strip_tags($_POST['serve']), $serve_list)) !== false) {
                unset($serve_list[$key]);
                setcookie('serve_list',json_encode($serve_list));
                $serve='localhost';
            }
            echo "<script>alert(\"Le serveur n'autorise pas la connexion\");document.location.href = 'index.php';</script>";
        }
    }

    function home()
    {
    	require('view/home.php');
    }

    function thread()
    {
        try{
            $link_thread = getLink_thread();
                header('Location: '.$link_thread.'');
        }
        catch(Exception $e){
            echo "<script>alert(\"Le serveur n'autorise pas la connexion\");document.location.href = 'index.php';</script>";
        }
    }