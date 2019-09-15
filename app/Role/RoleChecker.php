<?php


namespace App\Role;

use App\User;

class RoleChecker
{

    public function check(User $user, string $role)
    {
        // Admin has everything
        if ($user->hasRole(UserRole::ROLE_ADMIN)) {
            return true;
        }
        else if($user->hasRole(UserRole::ROLE_WORKER)) {
            $workerRoles = UserRole::getAllowedRoles(UserRole::ROLE_WORKER);

            if (in_array($role, $workerRoles)) {
                return true;
            }
        }

        return $user->hasRole($role);
    }
}