<style>
    /* Custom active color for nav-link */
    .nav-pills .nav-link.active {
        background-color: #ffcc00 !important; /* Custom active color */
        color: #000 !important; /* Optional: Set text color for better contrast */
        border-color: #ffcc00 !important;
    }

    /* Optional: Hover effect for links */
    .nav-pills .nav-link:hover {
        background-color: #ffd966; /* Slightly lighter color on hover */
        color: #000 !important;
    }
    .nav-link{
        color: #14315F;
    }
</style>

<div class="p-5">
    <div class="d-flex flex-column flex-shrink-0 p-3 rounded-3" style="width: 280px; background-color: #14315F">
        <ul class="nav nav-pills flex-column mb-auto p-2 text-center d-grid gap-3 fs-5">
            <li class="nav-item">
                <a href="/" class="nav-link fw-bold border rounded-3 {{Request::is('/') ? 'active' : 'bg-white'}}" aria-current="page">
                    Menu Utama
                </a>
            </li>
            <li class="nav-item">
                <a href="/syarat-peminjam" class="nav-link fw-bold border rounded-3 {{Request::is('syarat-peminjam') ? 'active' : 'bg-white'}}">
                    Syarat Pinjaman
                </a>
            </li>
            <li>
                <a href="#" class="nav-link fw-bold border rounded-3 bg-white">
                    Makmal
                </a>
            </li>
            <li>
                <a href="#" class="nav-link fw-bold border rounded-3 bg-white">
                    Hubungi
                </a>
            </li>
            <li>
                <a href="#" class="nav-link fw-bold border rounded-3 bg-white">
                    Soalan Lazim
                </a>
            </li>
        </ul>
    </div>
</div>
