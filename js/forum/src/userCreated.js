import UserCreatedNotification from 'flagrow/subscribed/notifications/UserCreatedNotification';

export default function (items, app) {
    app.notificationComponents.userCreated = UserCreatedNotification;

    items.add('userCreated', {
        name: 'userCreated',
        icon: 'user-plus',
        label: app.translator.trans('flagrow-subscribed.forum.settings.notify_user_created_label')
    }, -10);

    return items;
}
