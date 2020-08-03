<div id="aside" class="page-sidenav no-shrink bg-light nav-dropdown fade" aria-hidden="true">
    <div class="sidenav h-100 modal-dialog bg-light">
        <div class="navbar">
            <a href="#" class="navbar-brand ">
                <img src="{{ config('image.logo') }}" alt="logo" height="32px">
            </a>
        </div>
        <div class="flex scrollable hover">
            <div class="nav-active-text-primary" data-nav>
                <ul class="nav bg">
                    <li class="nav-header hidden-folded">
                        <span class="text-muted">{{ trans('supervisor.app.main') }}</span>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-icon text-primary"><i data-feather='home'></i></span>
                            <span class="nav-text">{{ trans('supervisor.app.dashboard') }}</span>
                        </a>
                    </li>
                    <li class="nav-header hidden-folded">
                        <span class="text-muted">{{ trans('supervisor.app.menu') }}</span>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-icon text-info"><i data-feather='calendar'></i></span>
                            <span class="nav-text">{{ trans('supervisor.app.course') }}</span>
                            <span class="nav-badge"><b class="badge-circle xs text-danger"></b></span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-icon text-danger"><i data-feather='list'></i></span>
                            <span class="nav-text">{{ trans('supervisor.app.subject') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-icon text-success"><i data-feather='file'></i></span>
                            <span class="nav-text">{{ trans('supervisor.app.task') }}</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav ">
                    <li>
                        <a href="#" class="">
                            <span class="nav-icon"><i data-feather='users'></i></span>
                            <span class="nav-text">{{ trans('supervisor.app.user') }}</span>
                            <span class="nav-caret"></span>
                        </a>
                        <ul class="nav-sub nav-mega">
                            <li>
                                <a href="#">
                                    <span class="nav-text">{{ trans('supervisor.app.trainee') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="">
                                    <span class="nav-text">{{ trans('supervisor.app.supervisor') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
