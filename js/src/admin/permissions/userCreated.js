export default function (items) {
    items.add('subscribeUserCreated', {
        icon: 'bell',
        label: app.translator.trans('flagrow-subscribed.admin.permission.subscribe_to_user_created'),
        permission: 'subscribeUserCreated'
    }, 95);
}
