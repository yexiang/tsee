<?php

namespace yexiang\tsee;

class Tsee {

  public function __construct() {
    
  }

  public function ex($cs) {
    if (isset($cs->retweeted_status)) {
      $cs = $cs->retweeted_status;
    }
    $text = $cs->full_text;
    if (isset($cs->entities->urls)) {
      foreach ($cs->entities->urls as $u) {
        $text = str_replace($u->url, '<a href="' . $u->expanded_url . '" target="_blank">' . $u->display_url . '</a>', $text);
      }
    }
    if (isset($cs->extended_entities->media)) {
      $temp_media_url = '';
      $temp_media = '';
      foreach ($cs->extended_entities->media as $m) {
        $temp_media_url = $m->url;
        $temp_media .= '<a href="' . $m->media_url_https . '" target="_blank">' . $m->display_url . '</a> ';
        if ($m->sizes->large->w >= 2046 || $m->sizes->large->h >= 2046) {
          $text .= '<a href="' . $m->media_url_https . ':orig" target="_blank"><img src="' . $m->media_url_https . '" class="twimg" alt="" /></a>';
        } elseif ($m->sizes->large->w >= 1198 || $m->sizes->large->h >= 1198) {
          $text .= '<a href="' . $m->media_url_https . ':large" target="_blank"><img src="' . $m->media_url_https . '" class="twimg" alt="" /></a>';
        } else {
          $text .= '<img src="' . $m->media_url_https . '" class="twimg" alt="" />';
        }
        if (isset($m->video_info->variants)) {
          $bitrate = [];
          foreach ($m->video_info->variants as $v) {
            if (strpos($v->url, '.mp4') > 0) {
              array_push($bitrate, $v->bitrate);
            }
          }
          sort($bitrate);
          foreach ($m->video_info->variants as $v) {
            if (strpos($v->url, '.mp4') > 0) {
              if ($v->bitrate == $bitrate[count($bitrate) - 1]) {
                $text .= '<video controls="controls" preload="none" src="' . $v->url . '"></video>';
                $text .= $v->url . "\n";
              }
            }
          }
        }
      }
      $text = str_replace($temp_media_url, $temp_media, $text);
    }
    return trim($text);
  }

}
