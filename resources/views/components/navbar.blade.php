<div class="my_navbar container-fluid">
    <div class="navbar_wrapper">
        <div class="my_navbar-left">
            <a href="{{route('home')}}">
                <div class="my_navbar-left">
                    <div class="my_logo">
                        <span>E|M</span>
                    </div>
                    <span>MyBnB</span>
                </div>
            </a>
        </div>
        <div class="my_navbar-right">
            @auth()
                <span class="navbar_nickname">Ciao, {{auth()->user()->nickname}}</span>
            @endauth
            <i id="toggler" class="fas fa-bars"></i>
        </div>
    </div>
    <div class="collapse" id="navbar_items_wrapper">
        <div class="navbar_items">
            <ul class="list-group list-group-flush text-center">
                @guest()
                    <li class="list-group-item">
                        <a class="navbar_link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="list-group-item">
                        <a class="navbar_link" href="{{route('register')}}">Registrati</a>
                    </li>
                @endguest
                @auth()
                    <li class="list-group-item">
                        <a class="navbar_link" href="{{route('apartments_dashboard')}}">Appartamenti</a>
                    </li>
                    <li class="list-group-item">
                        <a class="navbar_link" href="{{route('show_bookings')}}">Prenotazioni</a>
                    </li>
                    <li class="list-group-item">
                        <a class="navbar_link" href="{{route('message_dashboard')}}">Messaggi
                            <span class="badge badge-pill badge-info">{{auth()->user()->unreadMessages()?:null}}</span>
                        </a>
                    </li>
                    <li class="list-group-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <a class="navbar_link" href="{{route('logout')}}">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
                <li class="list-group-item">
                    <a class="navbar_link" href="{{route('show_faq')}}">FAQ</a>
                </li>
            </ul>
        </div>
    </div>
</div>