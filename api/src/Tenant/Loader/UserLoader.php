<?php

namespace App\Tenant\Loader;

use App\Service\UserService;
use Ds\Component\Tenant\Loader\Loader;

/**
 * Class UserLoader
 */
final class UserLoader implements Loader
{
    use User;

    /**
     * Constructor
     *
     * @param \App\Service\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->path = '/srv/api/config/tenant/loader/user.yaml';
    }
}
