<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size'];

    public function add($user) {

        $this->guardAgainstToManyMembers();

        $method = $user instanceof User ? 'save' : 'saveMany';
        $this->members()->$method($user);

    }

    public function members() {
      return  $this->hasMany(User::class, 'team_id', 'id');
    }

    public function count() {
        return $this->members()->count();
    }

    private function guardAgainstToManyMembers()
    {
        if ($this->count() >= $this->size) {
            throw new \Exception('oops');
        }
    }
}
