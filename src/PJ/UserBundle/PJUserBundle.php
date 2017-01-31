<?php

namespace PJ\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PJUserBundle extends Bundle
{
   public function getParent()

  {

    return 'FOSUserBundle';

  }
}
