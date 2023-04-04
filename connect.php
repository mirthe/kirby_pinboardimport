<?php

$startdatum = date ("Y-m-d", strtotime ($einddatum ."-7 days")); // ophalen vanaf vorige maandag
$pubdatum = date ("Y-m-d", strtotime ($einddatum ."-1 days")); // uitvoeren op maandagochtend, wegschrijven als zondag
$jaarweek = date ("oW", strtotime($pubdatum));

$exportdir = 'content/2_linklist/'; //Include trailing slash please

$url = "http://api.pinboard.in/v1/posts/all?auth_token=".option('mirthe.pinboard-import.token')."&fromdt=".$startdatum."&todt=".$einddatum;

// get the pins
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);					// this is the page we're grabbing
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);			// we want the data passed back
curl_setopt($ch, CURLOPT_USERAGENT, option('mirthe.pinboard-import.useragent'));		// set our useragent because del.icio.us likes it that way

$page = curl_exec($ch);
$HTTPCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
