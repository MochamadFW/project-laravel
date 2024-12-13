<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharCheckerHistories extends Model
{
    use HasFactory;

    protected $table = "char_checker_histories";
    protected $primaryKey = "id";
    protected $fillable = ["input_one","input_two","percentage"];
    public $timestamps = true;
    public $incrementing = true;
}
