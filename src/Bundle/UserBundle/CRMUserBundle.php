<?php

namespace CRM\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\ORM\EntityManager;
class CRMUserBundle extends Bundle {

    
    public function getParent() {
        return 'FOSUserBundle';
    }

   

}
