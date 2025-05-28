<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\models\Email;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with('emails')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->only(['first_name', 'last_name', 'phone']));

        foreach ($request->emails as $email) {
            $user->emails()->create(['email' => $email]);
        }

        return response()->json($user->load('emails'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user->load('emails');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->only(['first_name', 'last_name', 'phone']));

        if ($request->filled('emails')) {
            $user->emails()->delete();
            foreach ($request->emails as $email) {
                // Why create
                $user->emails()->create(['email' => $email]);
            }
        }

        return response()->json($user->load('emails'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    public function sendWelcomeEmail(User $user)
    {
        foreach ($user->emails as $email) {
            Mail::to($email->email)->send(new WelcomeUser($user));
        }

        return response()->json(['message' => 'Welcome emails sent']);
    }
}
