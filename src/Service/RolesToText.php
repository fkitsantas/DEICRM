<?php

namespace App\Service;

use App\Entity\User;

class RolesToText
{
    public function rolesToText($role, $type)
    {
        if ($type=="one") {
            if (implode("|", $role->getroles()) == "ROLE_ADMIN") {
                $role->rolestext = "ADMINISTRATOR";
            } elseif (implode("|", $role->getroles()) == "ROLE_MANAGER") {
                $role->rolestext = "MANAGER";
            } else {
                $role->rolestext = "EMPLOYEE";
            }
            return $role;
        } else {
            foreach ($role as $value) {
                if (implode("|", $value->getroles()) == "ROLE_ADMIN") {
                    $value->rolestext = "ADMINISTRATOR";
                } elseif (implode("|", $value->getroles()) == "ROLE_MANAGER") {
                    $value->rolestext = "MANAGER";
                } else {
                    $value->rolestext = "EMPLOYEE";
                }
            }

            return $role;
        }
    }
}
