<?php
	$visitURL = ""; 
	$token = "Put your readability API code here";
	if(isset($_GET["url"])) $visitURL = $_GET["url"];
	if(isset($_POST["url"])) $visitURL = $_POST["url"];

		$data = array('url' => $visitURL, 'token' => $token);                                                                    
		//$data_string = json_encode($data);                                                                                   
		$fields = array(
					'url'=>urlencode($visitURL),
					'token' =>urlencode($token) );
		$fields_string = "";			

		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string,'&');
		$queryURL = 'https://www.readability.com/api/content/v1/parser?' . $fields_string ;
	//	echo "Trying $queryURL \n<br/>";
 
	// set URL and other appropriate options
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryURL,
		CURLOPT_USERAGENT => 'Evan\'s Reader'
	));
	curl_setopt ($curl, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");
	//echo "Tring with " . dirname(__FILE__)."\\cacert.pem \n<br/>"; 
		$output = curl_exec($curl);
		$info = curl_getinfo($curl);
		curl_close($curl);
	//	echo "Info \n<br/>"; print_r( $info );
	$newOutput = json_decode($output);
	$array = array(
		"title" =>"",
		"content" => "",
	);
	foreach($newOutput as $key=>$value) {
		if($key == "title") {
			$array['title'] = cleanString($value);
		}
		if($key == "content") {
			$array['content'] = cleanString($value);
		}
	}
	$output = json_encode($array);
		print $output;
	//	echo "Output : " ; print_r($newOutput);

	
	function cleanString($input) 
	{		
		$str = @strip_tags($input);
		$str = @stripslashes($str);
		//$str = mysql_real_escape_string($str);
		$chaine = trim($str);  
		$chaine = strtr($chaine,  
		"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",  
		"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");  
		$chaine = strtr($chaine,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz");  
		$chaine = preg_replace('#([^.a-z0-9]+)#i', '-', $chaine);  
		$chaine = preg_replace('#-{2,}#','-',$chaine);  
		$chaine = preg_replace('#-$#','',$chaine);  
		$chaine = preg_replace('#^-#','',$chaine);  
		
		$newInput = strip_tags($chaine);
		$newInput = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $newInput);
		$newInput = preg_replace('#[^\w()/.%\-&]#',"",$newInput);
		$newInput = str_replace("-", " ",$newInput);
		$newInput = str_replace("x2019", "",$newInput);
		$newInput = str_replace("x2018", "",$newInput);
		$newInput = str_replace("xa0", "",$newInput);
		$newInput = str_replace(" s ", "'s ",$newInput);
		
		$newInput = sentence_case($newInput);

		return $newInput;
	}
	
function sentence_case($string) { 
    $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
    $new_string = ''; 
    foreach ($sentences as $key => $sentence) { 
        $new_string .= ($key & 1) == 0? 
            ucfirst(strtolower(trim($sentence))) : 
            $sentence.' '; 
    } 
    return trim($new_string); 
} 


?>
