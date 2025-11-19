@foreach ($data as $menuItem)
    @if ($menuItem->type == 'divider')
        <div class="menu-item">
            <div class="menu-content pt-8 pb-2">
                <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $menuItem?->menu_item_name }}</span>
            </div>
        </div>
    @else
        @if (empty($menuItem?->parent_id) && !empty($menuItem?->url) && $menuItem?->type === 'menu_item')
            <div class="menu-item">
                <a class="menu-link" href="{{ $menuItem?->url }}" target="{{ $menuItem?->target }}">
                    <span class="menu-icon">
                        <i class="{{ $menuItem?->icon_class }} fs-3"></i>
                    </span>
                    <span class="menu-title">{{ $menuItem?->menu_item_name }}</span>
                </a>
            </div>
        @else
            @php
                $hasTopChildren = false;
                if ($menuItem && method_exists($menuItem, 'relationLoaded') && $menuItem->relationLoaded('children')) {
                    $hasTopChildren = $menuItem->children && $menuItem->children->isNotEmpty();
                } elseif ($menuItem && method_exists($menuItem, 'children')) {
                    // Fallback for environments where relations were not eager-loaded
                    try { $hasTopChildren = $menuItem->children()->exists(); } catch (\Throwable $e) { $hasTopChildren = false; }
                }
            @endphp
            @if (empty($menuItem?->parent_id) && empty($menuItem?->url) && $menuItem?->type === 'menu_item' && $hasTopChildren)
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="{{ $menuItem?->icon_class }} fs-3"></i>
                        </span>
                        <span class="menu-title">{{ $menuItem?->menu_item_name }}</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @php
                                $childrenList = ($menuItem && method_exists($menuItem, 'relationLoaded') && $menuItem->relationLoaded('children'))
                                    ? $menuItem->children
                                    : (method_exists($menuItem, 'children') ? $menuItem->children()->get() : collect());
                            @endphp
                            @foreach ($childrenList as $childData)
                                @if ($childData?->type === 'menu_item')
                                    @if (!empty($childData?->url))
                                        {{-- Child menu item with URL --}}
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ $childData?->url }}" target="{{ $childData?->target }}">
                                                <span class="menu-bullet">
                                                    <span class="{{ $childData?->icon_class }}"></span>
                                                </span>
                                                <span class="menu-title">{{ $childData?->menu_item_name }}</span>
                                            </a>
                                        </div>
                                    @else
                                        {{-- Child menu item without URL - check for grandchildren --}}
                                        @php
                                            $childHasGrand = false;
                                            $grandChildrenList = collect();
                                            if ($childData && method_exists($childData, 'relationLoaded') && $childData->relationLoaded('children')) {
                                                $childHasGrand = $childData->children && $childData->children->isNotEmpty();
                                                $grandChildrenList = $childData->children;
                                            } elseif ($childData && method_exists($childData, 'children')) {
                                                try {
                                                    $grandChildrenList = $childData->children()->get();
                                                    $childHasGrand = $grandChildrenList->isNotEmpty();
                                                } catch (\Throwable $e) {
                                                    $childHasGrand = false;
                                                }
                                            }
                                        @endphp
                                        @if ($childHasGrand)
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion menu-active-bg">
                                                <span class="menu-link">
                                                    <span class="menu-bullet">
                                                        <span class="{{ $childData?->icon_class }} fs-3"></span>
                                                    </span>
                                                    <span class="menu-title">{{ $childData?->menu_item_name }}</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <div class="menu-sub menu-sub-accordion">
                                                    @foreach ($grandChildrenList as $grandChildData)
                                                        @if ($grandChildData?->type === 'menu_item' && !empty($grandChildData?->url))
                                                            <div class="menu-item">
                                                                <a class="menu-link" href="{{ $grandChildData?->url }}" target="{{ $grandChildData?->target }}">
                                                                    <span class="menu-icon">
                                                                        <i class="{{ $grandChildData?->icon_class }} fs-3"></i>
                                                                    </span>
                                                                    <span class="menu-title">{{ $grandChildData?->menu_item_name }}</span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                    </div>
                </div>
            @else
            @endif
        @endif
    @endif
@endforeach
