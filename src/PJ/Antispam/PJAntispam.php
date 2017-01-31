<?php

 
namespace PJ\BlogBundle\Antispam;


class PJAntispam

{

  public function isSpam($text)

  {

    return strlen($text) < 50;

  }

}