import {extend} from 'flarum/extend';
import NotificationGrid from 'flarum/components/NotificationGrid';
import Checkbox from 'flarum/components/Checkbox';

export default function (app) {
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
                const preference = app.forum.attribute('flagrow.subscribed.' + key);

                // "flagrow.subscribed.notify_postMentioned_alert_defaults"

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
}
