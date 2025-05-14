<?php

namespace App\Models\Menu\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';

    protected $table = 'module_items';

    protected $fillable = ['item_id', 'module_id', 'item_name', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function module(): BelongsTo
    {
        return $this->belongsTo(MenuModule::class, 'module_id');
    }
}
