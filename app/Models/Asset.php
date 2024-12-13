<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $table = "asset";
    protected $primaryKey = "id";
    protected $fillable = ["name", "purchase_price", "devaluation_percentage", "warehouse_id"];
    public $timestamps = true;
    public $incrementing = true;

    public function warehouses(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, "warehouse_id", "id");
    }
}
