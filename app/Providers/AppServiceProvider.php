<?php

namespace App\Providers;

use App\Repositories\Course\CourseRepository;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\CourseUser\CourseUserRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\SubjectUser\SubjectUserRepository;
use App\Repositories\CourseUser\CourseUserRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\SubjectUser\SubjectUserRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            SubjectRepositoryInterface::class,
            SubjectRepository::class
        );
        $this->app->singleton(
            CourseRepositoryInterface::class,
            CourseRepository::class
        );
        $this->app->singleton(
            SubjectUserRepositoryInterface::class,
            SubjectUserRepository::class
        );
        $this->app->singleton(
            CourseUserRepositoryInterface::class,
            CourseUserRepository::class
        );
        $this->app->singleton(
            TaskRepositoryInterface::class,
            TaskRepository::class
        );
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->singleton(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
    }

    public function boot()
    {
        //
    }
}
