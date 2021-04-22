<?php
echo $main = $_SERVER['DOCUMENT_ROOT']."";
$lastcheck=7*3600*24;
echo "<br>";
$_SESSION['x']=0;
function readDirs($path){
  $dirHandle = opendir($path);
  while($item = readdir($dirHandle)) {
    $newPath = $path."/".$item;
    if(is_dir($newPath) && $item != '.' && $item != '..') {
       //echo "Found Folder $newPath<br>";
       readDirs($newPath);
    }
    else{
    	if(time()-1*3600*24<filemtime($newPath) && $item!='.' && $item!='..'){
    		$_SESSION['x']=$_SESSION['x']+1;
    		 echo $newPath." time:".date("F d Y H:i:s.",filemtime($newPath))."<br>";
    	}
    	if(time()-1*3600*6<filectime($newPath) && $item!='.' && $item!='..'){
    		$_SESSION['x']=$_SESSION['x']+1;
    		 echo "<font color=red>".$newPath." c time:".date("F d Y H:i:s.",filectime($newPath))."</font><br>";
    	}
    	if(time()-1*3600*6<fileatime($newPath) && $item!='.' && $item!='..'){
    		$_SESSION['x']=$_SESSION['x']+1;
    		 echo "<font color=blue>".$newPath." last access time:".date("F d Y H:i:s.",fileatime($newPath))."</font><br>";
    	}
    	/*if(is_writable($newPath) && $item!='.' && $item!='..' && ){
    		$_SESSION['x']=$_SESSION['x']+1;
    		 echo "<font color=red>".$newPath." time:".date("F d Y H:i:s.",filemtime($newPath))."</font><br>";
    	}*/
    	
      //echo '&nbsp;&nbsp;Found File or .-dir '.$item.'<br>';
    }
  }
}

//$path =  "/";
//echo "$path<br>";

readDirs($main);

echo "<font color=red><b>".$_SESSION['x']."</b></font>";
?>
