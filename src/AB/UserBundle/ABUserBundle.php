<?php

namespace AB\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ABUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
