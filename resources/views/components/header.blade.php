<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="/" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            @auth
                <h1 class="sitename"><img src="{{ asset('assets/logo/logoGPT.png') }}" style="bg-color: white;"></h1>
            @endauth
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                @auth

                    <li class="nav-item">
                        <a class="nav-link" href="/users/manage">
                            <span>
                                Manage contracts
                                <u style="color: #ff4500">
                                    {{ auth()->user()->username }}
                                    @if (auth()->user()->roles->isNotEmpty())
                                        ({{ auth()->user()->roles->first()->name }})
                                        {{-- If multiple roles, you can use:
                                        ({{ auth()->user()->roles->pluck('name')->join(', ') }})
                                        --}}
                                    @endif
                                </u>
                            </span>
                        </a>
                    </li>
                    @if (auth()->user()->roles->isNotEmpty() &&
                            (auth()->user()->roles->first()->name == 'admin' || auth()->user()->roles->first()->name == 'hr'))
                        
                            <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard">
                                <span>
                                    Admin Page
                                </span>
                            </a>
                        </li>
                            <li class="nav-item">
                            <a class="nav-link" href="/users">
                                <span>
                                    Users
                                </span>
                            </a>
                        </li>
                        
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/courses">
                            <span>
                                Courses
                            </span>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/my-tasks">
                            <span>
                                Tasks
                            </span>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/surveys">
                            <span>
                                Surveys
                            </span>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/posts">
                            <span>
                                Posts
                            </span>
                        </a>

                    </li>

                    <li class="nav-item">
                        <form action="/logout" method="POST" class="inlien">
                            @csrf

                            <button type="submit" class="nav-link btn btn-link">Logout</button>

                        </form>
                    </li>
                @else

                @endauth
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
