<?php

namespace App\Models\Menu\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu\Master\MenuModule;
use App\Models\Menu\Master\ModuleItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'menu_item_id';

    protected $table = 'menu_items';

    protected $fillable = [
        'menu_item_id', 'menu_id', 'module_id', 'module_item_id', 'parent_id', 'type', 'menu_item_name', 'url', 'icon_class', 'order', 'target', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(ModuleItem::class, 'module_item_id','item_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(MenuModule::class, 'module_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('children')->orderBy('order');
    }
}
