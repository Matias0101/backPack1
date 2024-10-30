{{-- This file is used for menu items by any Backpack v6 theme --}}
<!-- <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')


<x-backpack::menu-item title="Categories" icon="la la-list" :link="backpack_url('category')" />
<x-backpack::menu-item title="Products" icon="la la-box" :link="backpack_url('product')" />
<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Tags" icon="la la-tag" :link="backpack_url('tag')" /> -->

<!-- 
 -->
 <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>
@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')

<!-- Menú para Usuarios -->
<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />

<!-- Inicio del grupo Paramétricas -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="parametricasDropdown" role="button" aria-expanded="false">
        <i class="la la-cogs nav-icon"></i> Paramétricas
    </a>
    <ul class="dropdown-menu" id="parametricasMenu">
        <li><a class="dropdown-item" href="{{ backpack_url('category') }}"><i class="la la-list nav-icon"></i> Categories</a></li>
        <li><a class="dropdown-item" href="{{ backpack_url('product') }}"><i class="la la-box nav-icon"></i> Products</a></li>
        <li><a class="dropdown-item" href="{{ backpack_url('tag') }}"><i class="la la-tag nav-icon"></i> Tags</a></li>
    </ul>
</li>

<!-- Script para forzar el dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('parametricasDropdown');
        const menu = document.getElementById('parametricasMenu');
        
        dropdown.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = dropdown.getAttribute('aria-expanded') === 'true';
            dropdown.setAttribute('aria-expanded', !isExpanded);
            menu.classList.toggle('show');
        });
    });
</script>
<!-- Fin del grupo Paramétricas -->

<x-backpack::menu-item title="Activity Logs" icon="la la-stream" :link="backpack_url('activity-log')" />