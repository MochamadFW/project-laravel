<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = "asset";
    protected $primaryKey = "id";
    protected $fillable = ["name", "location", "person_in_charge", "year_of_establishment"];
    public $timestamps = true;
    public $incrementing = true;

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, "warehouse_id", "id");
    }
}
