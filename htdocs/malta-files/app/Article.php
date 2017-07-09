<?php

namespace App;

use Symfony\Component\Yaml\Parser;

class Article
{

    public function __construct() {
        $this->yaml = new Parser();
    }

    public function getAllArticles($language) {
        $articleFolders = array_filter(glob('./resources/articles/' . $language . '/*'), 'is_dir');
        $articles = [];
        foreach($articleFolders as $folder) {
            $folderParts = explode("/", $folder);
            $details = $this->yaml->parse(file_get_contents($folder . '/details.yml'));
            if($details['date_publish'] <= date('Y-m-d')) {
                $articles[end($folderParts)] = $details;
            }
        }
        uasort($articles, function($a, $b){
            return $a['date_publish'] > $b['date_publish'];
        });
        //echo '<pre>'; print_r($articles); die();
        return $articles;
    }

    public function getSingleArticle($language, $slug) {
        $path = "./resources/articles/" . $language . "/" . $slug;
        if(!file_exists($path) && !is_dir($path)) {
            die('No such article');
        }
        $details = $this->yaml->parse(file_get_contents($path . "/details.yml"));
        $content = $this->yaml->parse(file_get_contents($path . "/content.yml"));
        return [
            'details' => $details,
            'content' => $content
        ];
    }

}
