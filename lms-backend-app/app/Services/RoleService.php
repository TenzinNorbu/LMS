<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleService{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository) 
    {
        $this->roleRepository = $roleRepository;
    }
}