<?php

namespace App\Http\Controllers;

use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationRepo;

    public function __construct(NotificationRepositoryInterface $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
    }

    public function readNotification($id)
    {
        $notification = $this->notificationRepo->getById($id);
        $data = explode(',', $notification->data);
        $routeName = explode('"',
            $data[config('notification.route_name.parent_location')])[config('notification.route_name.location')];
        $idItem = explode('"',
            $data[config('notification.id_item.parent_location')])[config('notification.id_item.location')];

        if ($notification->read_at == null) {
            $this->notificationRepo->update($id, [
                'read_at' => now(),
            ]);
        }

        return redirect()->route($routeName, $idItem);
    }

    public function getNotifications()
    {
        $notifications = Auth::user()->notifications;

        return $notifications;
    }
}
