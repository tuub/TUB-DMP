<?php

namespace App\Policies;

use App\User;
use App\Plan;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Determine if the given plan can be displayed by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return bool
     */
    public function show(User $user, Plan $plan)
    {
        return $user->id === $plan->project->user_id;
    }


    /**
     * Determine if the given plan can be created by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return bool
     */
    public function create(User $user, Project $project)
    {
        //return $user->id === $project->user_id;
        return tru;
    }


    /**
     * Determine if the given plan can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return bool
     */
    public function update(User $user, Plan $plan)
    {
        return $user->id === $plan->project->user_id;
    }
}
