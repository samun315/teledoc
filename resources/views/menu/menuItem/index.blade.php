@extends('master')

@section('title', 'Menu Item List')
@section('breadcrumbMainTitle', 'Menu Item List')
@section('page_css')
    <!-- Menu item custom css -->
    <link href="{{ asset('assets/custom/css/menu/menuItem/style.css') }}"
        {{ Sri::html('assets/custom/css/menu/menuItem/style.css') }} rel="stylesheet" type="text/css" />
@endsection
@section('content')
<x-toolbar-component title="Menu Item List" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Menu Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Menu Master', 'url' => 'javascript:void(0)'],
        ['label' => 'Menu', 'url' => route('menu.menu.index')],
        ['label' => 'Builder', 'url' => route('menu.menu.index')],
        ['label' => 'Menu Item List', 'active' => true],
    ]" modalTarget="openMenuItemModal" actionIcon="fas fa-plus-circle"
        actionLabel="Add New" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                @include('menu.menuItem.modal.addMenuItemModal')
                <!--begin::Card body-->
                <div class="card-body row">

                    <div class="cf mt-5">

                        <div class="dd" id="nestable">
                            <ol class="dd-list">
                                @foreach ($menuItems as $menuItem)
                                    @if ($menuItem->type == 'divider')
                                        <li class="dd-item" data-id="{{ $menuItem?->menu_item_id }}">
                                            <div class="dd-handle">Divider: {{ $menuItem?->menu_item_name }}</div>
                                            <div class="item_actions">
                                                <button class="btn btn-info btn-sm editMenuItem" data-bs-toggle="modal"
                                                    data-bs-target="#showModal"
                                                    data-edit-id="{{ $menuItem?->menu_item_id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm deleteMenuItem"
                                                    data-delete-id="{{ $menuItem?->menu_item_id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </li>
                                    @else
                                        @if (empty($menuItem?->parent_id) && !empty($menuItem?->url) && $menuItem?->type === 'menu_item')
                                            <li class="dd-item" data-id="{{ $menuItem?->menu_item_id }}">
                                                <div class="dd-handle">Menu: {{ $menuItem?->menu_item_name }}</div>
                                                <div class="item_actions">
                                                    <button class="btn btn-info btn-sm editMenuItem" data-bs-toggle="modal"
                                                        data-bs-target="#showModal"
                                                        data-edit-id="{{ $menuItem?->menu_item_id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm deleteMenuItem"
                                                        data-delete-id="{{ $menuItem?->menu_item_id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </li>
                                        @else
                                            @if (empty($menuItem?->parent_id) && empty($menuItem?->url) && $menuItem?->type === 'menu_item')
                                                <li class="dd-item" data-id="{{ $menuItem?->menu_item_id }}">
                                                    <div class="dd-handle">Parent: {{ $menuItem?->menu_item_name }}</div>
                                                    <div class="item_actions">
                                                        <button class="btn btn-info btn-sm editMenuItem"
                                                            data-bs-toggle="modal" data-bs-target="#showModal"
                                                            data-edit-id="{{ $menuItem?->menu_item_id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm deleteMenuItem"
                                                            data-delete-id="{{ $menuItem?->menu_item_id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <ol class="dd-list">
                                                        @foreach ($childDatas as $childData)
                                                            @if ($menuItem?->menu_item_id == $childData?->parent_id && $menuItem?->type === 'menu_item')
                                                                @if (!empty($childData?->parent_id) && !empty($childData?->url) && $childData?->type === 'menu_item')
                                                                    <li class="dd-item"
                                                                        data-id="{{ $childData?->menu_item_id }}">
                                                                        <div class="dd-handle">Child:
                                                                            {{ $childData?->menu_item_name }}</div>
                                                                        <div class="item_actions">
                                                                            <button class="btn btn-info btn-sm editMenuItem"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#showModal"
                                                                                data-edit-id="{{ $childData?->menu_item_id }}">
                                                                                <i class="fas fa-edit"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm deleteMenuItem"
                                                                                data-delete-id="{{ $childData?->menu_item_id }}">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                @else
                                                                    @if (!empty($childData?->parent_id) && empty($childData?->url) && $childData?->type === 'menu_item')
                                                                        <li class="dd-item"
                                                                            data-id="{{ $childData?->menu_item_id }}">
                                                                            <div class="dd-handle">Child:
                                                                                {{ $childData?->menu_item_name }}</div>
                                                                            <div class="item_actions">
                                                                                <button
                                                                                    class="btn btn-info btn-sm editMenuItem"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#showModal"
                                                                                    data-edit-id="{{ $childData?->menu_item_id }}">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm deleteMenuItem"
                                                                                    data-delete-id="{{ $childData?->menu_item_id }}">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                            <ol class="dd-list">
                                                                                @foreach ($grandChildDatas as $grandChildData)
                                                                                    @if ($childData?->menu_item_id == $grandChildData?->parent_id && $childData?->type === 'menu_item')
                                                                                        <li class="dd-item"
                                                                                            data-id="{{ $grandChildData?->menu_item_id }}">
                                                                                            <div class="dd-handle">Grand
                                                                                                Child:
                                                                                                {{ $grandChildData?->menu_item_name }}
                                                                                            </div>
                                                                                            <div class="item_actions">
                                                                                                <button
                                                                                                    class="btn btn-info btn-sm editMenuItem"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#showModal"
                                                                                                    data-edit-id="{{ $grandChildData?->menu_item_id }}">
                                                                                                    <i
                                                                                                        class="fas fa-edit"></i>
                                                                                                </button>
                                                                                                <button type="button"
                                                                                                    class="btn btn-danger btn-sm deleteMenuItem"
                                                                                                    data-delete-id="{{ $grandChildData?->menu_item_id }}">
                                                                                                    <i
                                                                                                        class="fas fa-trash"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ol>
                                                                        </li>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </ol>
                                                </li>
                                            @else
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/menu/menuItem/index.js') }}"
        {{ Sri::html('assets/custom/js/menu/menuItem/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {

            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };

            // activate Nestable for list 1
            $('#nestable').nestable({
                    group: 1
                })
                .on('change', updateOutput);

            // activate Nestable for list 2
            $('#nestable2').nestable({
                    group: 1
                })
                .on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));

            $('#nestable-menu').on('click', function(e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });

            $('#nestable3').nestable();

        });

        $('.dd').nestable({
            maxDepth: 3
        });

        $('.dd').on('change', function(e) {
            console.log(JSON.stringify($('.dd').nestable('serialize')));

            $.ajax({
                type: "DELETE",
                url: '{{ route('menu.menu.menuItem.order', $menuInfos?->menu_id) }}',
                dataType: "JSON",
                type: "POST",
                data: {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response?.statusCode === 200) {
                        toastr.success(response?.message, "Success!");
                    } else {
                        toastr.error(
                            "Could not delete parent, need to delete child first.'!"
                        );
                    }
                }
            });
        });
    </script>

@endsection
