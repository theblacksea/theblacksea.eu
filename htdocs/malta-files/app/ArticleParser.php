<?php

namespace App;

use Symfony\Component\Yaml\Parser;

$yaml = new Parser();
$content = $yaml->parse(file_get_contents('./content/english.yml'));

class ArticleParser {

  function component($type, $data) {
    include('components/' . $type . '.php');
  }

}

//echo '<pre>'; print_r($text); die();