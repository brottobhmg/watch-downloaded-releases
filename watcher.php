<?php


if (isset($_GET["username"])){

    $context = stream_context_create([
        "http" => [
            "method"        => "GET",
            "ignore_errors" => true,
            "user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko)"
        ],
    ]);
    $response=file_get_contents("https://api.github.com/users/".$_GET["username"]."/repos",false,$context);
    $response=json_decode($response);
    //print(count($response));
    
    echo "<html><body><table border=1><tr><th>Repo<th>Downloads";
    for ($i=0;$i<count($response);$i++){
        echo "<tr><td>";
        print_r($response[$i]->name);
        $response2=file_get_contents("https://api.github.com/repos/".$_GET["username"]."/".$response[$i]->name."/releases",false,$context);
        $response2=json_decode($response2);
        $download_count=$response2[0]->assets[0]->download_count;
        echo "<td>".$download_count;

    }
    echo "</table></body></html>";


} else {
    echo "<html><body><form action=".$_SERVER['PHP_SELF']." method=get>";
    echo "<h1>Insert Github's username to see the download count of releases of all repos</h1>";
    echo "<input type=text name=username />";
    echo "<input type=submit name=send value=Send />";
    echo "";
    echo "</form></body></html>";
}



?>
