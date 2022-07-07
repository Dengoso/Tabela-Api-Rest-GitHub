<?php

$output='


'
;

$headers = [
  "User-Agent: Example REST API Client"
];

$ch = curl_init("https://api.github.com/users/Dengoso/repos");

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

//echo $response;

$json_data = json_decode($response, true);

//$json_data = json_decode(file_get_contents('arquivo.json'));

?>

<?php
//fetch_data.php

if($json_data['message'] == "API rate limit exceeded for 177.34.168.71. (But here's the good news: Authenticated requests get a higher rate limit. Check out the documentation for more details.)"){

    $output .= "<tr>";
    $output .= "<td>-</td>";
    $output .= "<td>-</td>";
    $output .= "<td>-</td>";
    $output .= "<td>-</td>";
    $output .= "</tr>";	   

}else if(isset($_POST["action"])){

	$exibir=array();
	foreach ($json_data as $data)if( ((isset($_POST['wiki'])==true && $data['has_wiki']==true) || !isset($_POST['wiki'])) && ((isset($_POST['archived'])==true && $data['archived']==true) || !isset($_POST['archived'])) && ((isset($_POST['template'])==true && $data['is_template']==true) || !isset($_POST['template'])) ){

	    array_push($exibir,array($data["id"],$data["name"],$data["language"],$data["updated_at"]));

	}

	$array2=array(0);
	if(isset($_POST["language"]))
	{
		$brand_filter = implode("','", $_POST["language"]);
		$brand_filter2 = explode("','",$brand_filter);
		$array2 = explode(",",str_replace("'", '', $brand_filter));

	}

	foreach ($exibir as $data){

		if( (in_array($data[2],$array2) || !isset($_POST['language'])) ){

	    $output .= "<tr><td>" .$data[0]."</td>";
	    $output .= '<td>'.$data[1]."</td>";
	    $output .= '<td>'.$data[2]."</td>";
	    $output .= '<td>'.date("Y-m-d H:i",strtotime($data[3]))."</td>";
	    $output .= "</tr>";	    

		}else if(!isset($_POST['language']) ){

	    $output .= "<tr><td>" .$data[0]."</td>";
	    $output .= '<td>'.$data[1]."</td>";
	    $output .= '<td>'.$data[2]."</td>";
	    $output .= '<td>'.date("Y-m-d",strtotime($data[3]))."</td>";
	    $output .= "</tr>";	    

		}
	
	}

}


echo $output;

?>

