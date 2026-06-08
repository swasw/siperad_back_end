<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('admin.home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Alat
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('barang.index') }}">Data Alat</a>
                        <a class="nav-link" href="{{ route('peminjaman-barang.index') }}">Peminjaman Alat</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-house"></i></div>
                    Ruang
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('ruang.index') }}">Data Ruang</a>
                        <a class="nav-link" href="{{ route('jadwal-ruangan.index') }}">Jadwal Ruangan</a>
                        <a class="nav-link" href="{{ route('jadwal-ruangan.view') }}">Lihat Jadwal Ruangan</a>
                        <a class="nav-link" href="{{ route('peminjaman-ruang.index') }}">Peminjaman Ruang</a>
                    </nav>
                </div>
                <a class="nav-link" href="{{ route('matkul.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                    Mata Kuliah
                </a>
                <a class="nav-link" href="{{ route('dosen.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                    Dosen
                </a>
                <a class="nav-link" href="{{ route('jam.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                    Jam
                </a>
                <a class="nav-link" href="{{ route('prodi.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Prodi
                </a>
                <a class="nav-link" href="{{ route('angkatan.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Angkatan
                </a>
                <div class="collapse" id="collapseLayouts4" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="">Data Angkatan</a>

                    </nav>
                </div>
                <a class="nav-link" href="{{ route('mahasiswa.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Mahasiswa
                </a>
                <a class="nav-link" href="{{ route('feedback.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                    Feedback
                </a>
                <a class="nav-link" href="{{ route('import.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-excel"></i></div>
                    Input Multiple Data
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth()->user()->name }}
        </div>
    </nav>
</div>
