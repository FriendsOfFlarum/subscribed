import {extend} from 'flarum/extend';
import NotificationGrid from 'flarum/components/NotificationGrid';
import discussionCreated from 'flagrow/subscribed/discussionCreated';
import userCreated from 'flagrow/subscribed/userCreated';
import Checkbox from 'flarum/components/Checkbox';

app.initializers.add('flagrow-subscribed', function(app) {
    extend(NotificationGrid.prototype, 'notificationTypes', function(items) {

        items = discussionCreated(items, app);
        items = userCreated(items, app);

        return items;
    });

    extend(NotificationGrid.prototype, 'init', function () {
        let adds = [];

        this.methods.forEach((type) => {
            adds.push({
                parent: type.name,
                name: type.name + '_defaults',
                icon: type.icon,
                label: app.translator.trans('flagrow-subscribed.forum.settings.defaults_label', {setting: type.label})
            })
            adds.push({
                parent: type.name,
                name: type.name + '_forced',
                icon: type.icon,
                label: app.translator.trans('flagrow-subscribed.forum.settings.forced_label', {setting: type.label})
            })
        })

        this.types.forEach(type => {
            adds.forEach(method => {
                const parent = this.preferenceKey(type.name, method.parent);
                const key = this.preferenceKey(type.name, method.name);
                const preference = this.props.user.preferences()[key];
                const parentPreference = this.props.user.preferences()[parent];

                this.inputs[key] = new Checkbox({
                    state: !!preference,
                    disabled: typeof parentPreference === 'undefined',
                    onchange: () => this.toggle([key])
                });
            });
        });

        this.methods = this.methods.concat(adds)

        this.methods.sort((a, b) => {
            if (a.name < b.name) {
                return -1;
            }
            if (a.name > b.name) {
                return 1;
            }

            return 0;
        })
    })
});
