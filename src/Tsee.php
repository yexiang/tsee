<?php
namespace yexiang\tsee;

class Tsee {
  public static $OK = 0;
  public function __construct() {

  }
  public function ex($cs) {
    $text='';
    if(isset($cs->entities->urls)){
      foreach ($cs->entities->urls as $u) {
        $text = str_replace($u->url, '<a href="'.$u->expanded_url.'" target="_blank">'.$u->display_url.'</a>', $text);
      }
    }
  
  }
    
}