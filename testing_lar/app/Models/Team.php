<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size'];

    public function add($users) {

        $this->guardAgainstToManyMembers($users);

        $method = $users instanceof User ? 'save' : 'saveMany';
        $this->members()->$method($users);

    }

    public function remove($users = null)
    {
        if ($users instanceof  User) {
            return   $users->leaveTeam();
        }

        return  $this->removeMany($users);
    }
    public function removeMany($users)
    {
        return  $this->members()
                ->whereIn('id', $users->pluck('id'))
                ->update(['team_id' => null]);
    }

    public function restart()
    {
        return $this->members()->update(['team_id' => null]);
    }

    public function members() {
      return  $this->hasMany(User::class, 'team_id', 'id');
    }

    public function count() {
        return $this->members()->count();
    }

    private function guardAgainstToManyMembers($users)
    {
        $numUsersToAdd = ($users instanceof User) ? 1 : $users->count();

        $newTeamCount = $this->count() + $numUsersToAdd;

        if ($newTeamCount > $this->size) {
            throw new \Exception('oops');
        }
    }


}
