<?php
  function getDebutHTML(string $title = "Title content") : string
  {
    $debut = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
    <!-- encodage utf-8 -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!--<link rel="Stylesheet" href="" type="text/css" /> -->
    <link rel="Stylesheet" href="css/Css.css" type="text/css" />
    <!--<style type="text/css"></style> -->

    <title>';

    $debut .= $title;

    $debut .= '</title>

    </head>

    <body>';
    return $debut;
  }

  function getFinHTML(): string
  {
    $fin = '</body>
    </html>';
    return $fin;
  }

  function intoBalise(string $nomElement, string $contenuElement, array $params=null): string
  {
    $balise = "<$nomElement";
    if(!is_null($params)) {
      foreach($params as $key => $val){
        $balise .= " $key = '$val'";
      }
    }
    if($contenuElement != "") {
      $balise .= ">$contenuElement</$nomElement>";
    }
    else {
      $balise .= ' />';
    }
    return $balise;
  }
?>
