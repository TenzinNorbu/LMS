<?php

namespace App\Http\Controllers\SecurityModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['profile']]);
    }

    public function profile(ProfileRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['imageUrl'] = $request->file('imageUrl')->store('imageUrl');
        $data = User::create($validatedData);

        return response($data, Response::HTTP_CREATED);
    }
}
