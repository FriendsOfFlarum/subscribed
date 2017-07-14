export default function (items) {

    items.add('discussionCreated', {
        name: 'discussionCreated',
        icon: 'pencil',
        label: app.translator.trans('flagrow-subscribed.forum.settings.notify_discussion_created_label')
    }, 5);

    return items;
}
