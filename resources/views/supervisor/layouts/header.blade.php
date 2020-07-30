<div id="header" class="page-header ">
    <div class="navbar navbar-expand-lg">
        <div class="collapse navbar-collapse order-2 order-lg-1" id="navbarToggler">
            <form class="input-group m-2 my-lg-0 ">
                <div class="input-group-prepend">
                    <button type="button" class="btn no-shadow no-bg px-0">
                        <i data-feather="search"></i>
                    </button>
                </div>
                <input type="text" class="form-control no-border no-shadow no-bg typeahead"
                    placeholder="{{ trans('supervisor.app.search_components') }}" data-plugin="typeahead"
                    data-api="bower_components/bower_package/api/menu.json">
            </form>
        </div>
        <ul class="nav navbar-menu order-1 order-lg-2">
            <li class="nav-item dropdown">
                <a class="nav-link px-2" data-toggle="dropdown">
                    <i data-feather="settings"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-center mt-3 w animate fadeIn">
                    <div class="setting px-3">
                        <div class="mb-2 text-muted">
                            <strong>{{ trans('supervisor.app.setting') }}:</strong>
                        </div>
                        <div class="mb-2 text-muted">
                            <strong>{{ trans('supervisor.app.color') }}:</strong>
                        </div>
                        <div class="mb-2">
                            <label class="radio radio-inline ui-check ui-check-md">
                                <input type="radio" name="bg" value="">
                                <i></i>
                            </label>
                            <label class="radio radio-inline ui-check ui-check-color ui-check-md">
                                <input type="radio" name="bg" value="bg-dark">
                                <i class="bg-dark"></i>
                            </label>
                        </div>
                        <div class="mb-2 text-muted">
                            <strong>{{ trans('supervisor.app.language') }}:</strong>
                        </div>
                        <div class="mb-2">
                            <div class="navbar-header language">
                                <a class="navbar-brand float-left" href="{{ route('user.change-language', ['en']) }}">
                                    <img class="language-image" src="{{ config('image.en') }}" alt="English">
                                </a>
                                <a class="navbar-brand float-left" href="{{ route('user.change-language', ['vi']) }}">
                                    <img src="{{ config('image.vi') }}" alt="VietNam" class="language-image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link d-flex align-items-center px-2 text-color">
                    <span class="avatar-image avatar w-24">
                        <img src="{{ asset('image/a3.jpg') }}" alt="..."></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right w mt-3 animate fadeIn">
                    <a class="dropdown-item" href="#">
                        <span>{{ trans('supervisor.app.fullname') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <span>{{ trans('supervisor.app.profile') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <span>{{ trans('supervisor.app.account_settings') }}</span>
                    </a>
                    <a class="dropdown-item" href="#">{{ trans('supervisor.app.sign_out') }}</a>
                </div>
            </li>
            <li class="nav-item d-lg-none">
                <a href="#" class="nav-link px-2" data-toggle="collapse" data-toggle-class
                    data-target="#navbarToggler">
                    <i data-feather="search"></i>
                </a>
            </li>
            <li class="nav-item d-lg-none">
                <a class="nav-link px-1" data-toggle="modal" data-target="#aside">
                    <i data-feather="menu"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
