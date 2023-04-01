<?php // feed parsen
$xmlUrl = trim($page); // XML feed file/URL
$xmlObj = simplexml_load_string($xmlUrl);

$linklist = "<dl>". PHP_EOL;
foreach($xmlObj as $item)
{
    $linklist .= '<dt><a href="' .  $item['href'] .'">';
    $linklist .= htmlentities($item['description']);
    $linklist .= "</a></dt>". PHP_EOL;
    if (  ! empty( trim($item['extended'])) ){$linklist .= "<dd>" . htmlentities($item['extended']) . "</dd>". PHP_EOL;}
}
$linklist .= "</dl>". PHP_EOL;

$jaar = date ("o", strtotime($pubdatum));
$folder = str_replace('-', '', $pubdatum);

if (!is_dir($exportdir . $jaar)) {
    // folder for jaar doesn't exist, make it
    mkdir($exportdir . $jaar);
    file_put_contents($exportdir . $jaar. '/linklist_year.md', 'title: ' . $jaar);
}

if (!is_dir($exportdir . $jaar .'/'. $folder)) {
    // dir doesn't exist, make it
    mkdir($exportdir . $jaar .'/'. $folder);
}

// Compile the content of the file to write
$strtowrite = "Title: " . date ("o", strtotime($pubdatum)) ." w" . date ("W", strtotime($pubdatum))
. PHP_EOL . "----" . PHP_EOL
. "Date: " . $pubdatum
. PHP_EOL . "----" . PHP_EOL
. "Text: " . $linklist;

// Save to file
file_put_contents($exportdir . $jaar .'/'. $folder. '/linklist_week.md', $strtowrite);


/* TODO omschrijven met page create..
$page = Page::create([
    'parent' => page('linklist/2023'), // TODO dynamisch maken
    'slug'     => str_replace('-', '', $pubdatum) .'_' . $cleantitle,
    'template' => 'linklist_week',
    'isDraft' => false,
    'content' => [
      'title'  => date ("o", strtotime($pubdatum)) ." w" . date ("W", strtotime($pubdatum)),
      'date' => $pubdatum,  // TODO timezone corrigeren
      'text' => linklist
    ]
  ]); */
