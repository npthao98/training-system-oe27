$(document).ready(function() {
    $('#navbarDropdown').on('click', function () {
        $('.menu-notification').empty();
        $.ajax({
            url: '/notifications/data',
            type: 'get',
            dataType: 'json',
            success: function (notifications) {
                if (notifications.error) {
                    toastr.error(data.error, 'Notification', {timeOut: 5000});
                } else {
                    var notification;
                    for (notification of notifications) {
                        var style_class;
                        if (notification.read_at == null) {
                            style_class = 'alert alert-info notification-item';
                        } else {
                            style_class = 'alert alert-light notification-item';
                        }
                        var title = array_const[notification.data.title];
                        var newNotificationHtml = `
                            <a class="float-left ` + style_class + `"
                                href="/read-notification/` + notification.id + `">
                                ` + title + `<b>` + notification.data.titleable + `</b>
                            </a>
                        `;
                        $('.menu-notification').prepend(newNotificationHtml);
                    }
                }
            },
        });
    });
    var numberNotifications = $('#number-notifications').text();
    var user_id = $('#user_id').val();
    var pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
        encrypted: true,
        cluster: "ap1"
    });
    var channel = pusher.subscribe('notification-channel');
    channel.bind('notification-event', function(data) {
        if (data.user_id == user_id) {
            numberNotifications++;
            $('#number-notifications').text(numberNotifications);
        }
    });
});
