<?php

class Flickr { 
    
    // clé API
    private $apiKey; 

    // pour débug
    private $debug = false;
    
    // on passe la clé API au constructeur de la classe
    public function __construct($apikey) {
        $this->apiKey = $apikey;
    } 
    
    // récupèrer une photo sur un thème donnée
    public function getRandomPhoto($text) {

        // récupèrer une liste de photos
        $photos = $this->search($text);

        // récupèrer les liens vers la première photo récupèrer précédement
        if(!empty($photos->photos->photo)) {
            foreach($photos->photos->photo as $k=>$v) {
                if($this->debug) {
                    print_r($this->getPhoto($v->id)->sizes->size);    
                }
                return $this->getPhoto($v->id)->sizes->size;    
            }    
        }

    }

    // rechercher des photos à partir d'un texte
    public function search($text) { 
        $params = array(
            'method' => 'flickr.photos.search',
            'text' => $text,
            'per_page' => 2,
        );
        return $this->request($params); 
    } 

    // récupèrer une photo à partir de son ID
    public function getPhoto($photo_id) { 
        $params = array(
            'method' => 'flickr.photos.getSizes',
            'api_key' => $this->apiKey,
            'photo_id' => $photo_id,
        );
        return $this->request($params);
    } 

    // executer la requete
    public function request($params) { 
        $params['format'] = 'json';
        $params['nojsoncallback'] = 1;
        $params['api_key'] = $this->apiKey;
        $url = 'http://flickr.com/services/rest/?'; 
        $search = $url.http_build_query($params);
        $result = $this->file_get_contents_curl($search); 
        $result = json_decode($result);
        return $result;
    }

    // executer la requete avec Curl 
    private function file_get_contents_curl($url) {
        if($this->debug) {
            echo $url;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($retcode == 200) {
            return $data;
        } else {
            return null;
        }
    }   

}
?>