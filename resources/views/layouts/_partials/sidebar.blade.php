<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('backend/img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">RuangAdmin</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Features
    </div>
    <li class="nav-item {{ request()->segment(1) == 'master' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
            aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Master</span>
        </a>
        <div id="collapseBootstrap" class="collapse {{ request()->segment(1) == 'master' ? 'show' : '' }}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master</h6>
                <a class="collapse-item {{ request()->segment(2) == 'satuan' ? 'active' : '' }}"
                    href="{{ route('satuan.index') }}">Satuan</a>
                <a class="collapse-item {{ request()->segment(2) == 'barang' ? 'active' : '' }}"
                    href="{{ route('barang.index') }}">Barang</a>
                <a class="collapse-item {{ request()->segment(2) == 'user' ? 'active' : '' }}"
                    href="{{ route('user.index') }}">User</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ request()->segment(1) == 'transaksi' ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm"
            aria-expanded="true" aria-controls="collapseForm">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Transaksi</span>
        </a>
        <div id="collapseForm" class="collapse {{ request()->segment(1) == 'transaksi' ? 'show' : '' }}"
            aria-labelledby="headingForm" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Transaksi</h6>
                <a class="collapse-item {{ request()->segment(2) == 'penjualan' ? 'active' : '' }}"
                    href="{{ route('penjualan.index') }}">Penjualan</a>
                <a class="collapse-item {{ request()->segment(2) == 'purchase-order' ? 'active' : '' }}"
                    href="{{ route('purchase-order.index') }}">Purchase Order</a>
                <a class="collapse-item" href="form_advanceds.html">Profit</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable"
            aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Laporan</h6>
                <a class="collapse-item" href="form_basics.html">Penjualan</a>
                <a class="collapse-item" href="form_advanceds.html">Purchase Order</a>
                <a class="collapse-item" href="form_advanceds.html">Profit</a>
                <a class="collapse-item" href="form_advanceds.html">Peramalan Profit</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="ui-colors.html">
            <i class="fas fa-fw fa-palette"></i>
            <span>Peramalan</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
