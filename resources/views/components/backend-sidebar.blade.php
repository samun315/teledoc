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
            @if (empty($menuItem?->parent_id) && empty($menuItem?->url) && $menuItem?->type === 'menu_item')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="{{ $menuItem?->icon_class }} fs-3"></i>
                        </span>
                        <span class="menu-title">{{ $menuItem?->menu_item_name }}</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @if ($menuItem && $menuItem->children->isNotEmpty())
                            @foreach ($menuItem?->children as $childData)
                                {{-- Validate parent-child relationship and type --}}
                                @if ($menuItem->menu_item_id === $childData?->parent_id && $menuItem->type === 'menu_item')
                                    {{-- Handle child menu item with URL --}}
                                    @if ($childData?->type === 'menu_item' && !empty($childData?->parent_id))
                                        @if (!empty($childData?->url))
                                            <div class="menu-item">
                                                <a class="menu-link" href="{{ $childData?->url }}" target="{{ $childData?->target }}">
                                                    <span class="menu-bullet">
                                                        <span class="{{ $childData?->icon_class }}"></span>
                                                    </span>
                                                    <span class="menu-title">{{ $childData?->menu_item_name }}</span>
                                                </a>
                                            </div>
                                        @else
                                            {{-- Handle child menu item without URL --}}
                                            <div data-kt-menu-trigger="click"
                                                class="menu-item menu-accordion menu-active-bg">
                                                <span class="menu-link">
                                                    <span class="menu-bullet">
                                                        <span class="{{ $childData?->icon_class }} fs-3"></span>
                                                    </span>
                                                    <span class="menu-title">{{ $childData?->menu_item_name }}</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <div class="menu-sub menu-sub-accordion">
                                                    @if ($childData && $childData->children->isNotEmpty())
                                                        @foreach ($childData->children as $grandChildData)
                                                            {{-- Validate grandchild relationship and type --}}
                                                            @if ($childData->menu_item_id === $grandChildData?->parent_id && $grandChildData?->type === 'menu_item')
                                                                <div class="menu-item">
                                                                    <a class="menu-link"
                                                                        href="{{ $grandChildData?->url }}" target="{{ $grandChildData?->target }}">
                                                                        <span class="menu-icon">
                                                                            <i
                                                                                class="{{ $grandChildData?->icon_class }} fs-3"></i>
                                                                        </span>
                                                                        <span
                                                                            class="menu-title">{{ $grandChildData?->menu_item_name }}</span>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        @endif


                    </div>
                </div>
            @else
            @endif
        @endif
    @endif
@endforeach
