<div class="my_navbar container-fluid">
    <div class="navbar_wrapper">
        <div class="my_navbar-left">
            <a href="">
                <div class="my_navbar-left">
                    <div class="my_logo">
                        <span>E|M</span>
                    </div>
                    <span>MyBnB</span>
                </div>
            </a>
        </div>
        <div class="my_navbar-right">
            <i id="toggler" class="fas fa-bars"></i>
        </div>
    </div>
    <div class="collapse" id="navbar_items_wrapper">
        <div class="navbar_items">
            <ul class="list-group list-group-flush text-center">
                <li class="list-group-item">Login</li>
                <li class="list-group-item">Registrati</li>
                @auth()
                    <li class="list-group-item">Logout</li>
                @endauth
            </ul>
        </div>
    </div>
</div>