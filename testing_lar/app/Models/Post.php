<?php

namespace App\Models;

use App\Likeability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    use Likeability;

}
