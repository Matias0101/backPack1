{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')


<x-backpack::menu-item title="Categories" icon="la la-list" :link="backpack_url('category')" />
<x-backpack::menu-item title="Products" icon="la la-box" :link="backpack_url('product')" />
<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Tags" icon="la la-tag" :link="backpack_url('tag')" />