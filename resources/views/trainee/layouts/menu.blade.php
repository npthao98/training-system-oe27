<div id="aside" class="page-sidenav no-shrink bg-light nav-dropdown fade" aria-hidden="true">
    <div class="sidenav h-100 modal-dialog bg-light">
        <div class="navbar">
            <a href="#" class="navbar-brand ">
                <img src="{{ asset(config('image.logo')) }}"
                    alt="{{ trans('trainee.app.logo') }}" height="32px">
            </a>
        </div>
        <div class="flex scrollable hover">
            <div class="nav-active-text-primary" data-nav>
                <ul class="nav bg">
                    <li class="nav-header hidden-folded">
                        <span class="text-muted">{{ trans('supervisor.app.main') }}</span>
                    </li>
                    <li>
                        <a href="{{ route('home') }}">
                            <span class="nav-icon text-primary">
                                <i data-feather='home'></i>
                            </span>
                            <span class="nav-text">
                                {{ trans('supervisor.app.dashboard') }}
                            </span>
                            <span class="nav-badge dashboard">
                                <b class="badge-circle xs text-danger"></b>
                            </span>
                        </a>
                    </li>
                    <li class="nav-header hidden-folded">
                        <span class="text-muted">
                            {{ trans('supervisor.app.menu') }}
                        </span>
                    </li>
                    <li>
                        <a href="{{ route('course.index') }}">
                            <span class="nav-icon text-danger">
                                <i data-feather='list'></i>
                            </span>
                            <span class="nav-text">
                                {{ trans('supervisor.app.course') }} -
                                {{ trans('supervisor.app.subject') }}
                            </span>
                            <span class="nav-badge course">
                                <b class="badge-circle xs text-danger"></b>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('progress') }}">
                            <span class="nav-icon text-success">
                                <i data-feather='trending-up'></i>
                            </span>
                            <span class="nav-text">
                                {{ trans('trainee.app.progress') }}
                            </span>
                            <span class="nav-badge progress">
                                <b class="badge-circle xs text-danger"></b>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
