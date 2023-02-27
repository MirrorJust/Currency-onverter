<?php

    $url = "https://cbr.ru/scripts/XML_daily.asp";
    $strinXml = file_get_contents($url);
    $xml = simplexml_load_string($strinXml);

    $remoteCount = [];
    foreach ($xml as $child) {
        $remoteCount[] = $child;
    }


    $mysql = new mysqli('localhost', 'vh366056_admin', 'admin_5057911762', 'vh366056_register_bd');
    for($i=0; $i < count($remoteCount); $i++) {
        $name = $remoteCount[$i]->Name;
        $nominal = $remoteCount[$i]->Nominal;
        $valueArr = (array)$remoteCount[$i]->Value;
        $value = round((float)str_replace(',', '.', $valueArr[0]), 2);

        $mysql->query("INSERT INTO `exchange_rates`(`name`, `nominal`, `in_rubles`) VALUES('$name', '$nominal', '$value')");
        
    }
    $mysql->close();

    header('Location: /');
    
 
?>