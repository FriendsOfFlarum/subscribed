import {extend} from "flarum/extend";
import AdminNav from "flarum/components/AdminNav";
import AdminLinkButton from "flarum/components/AdminLinkButton";
import SubscriptionPane from "flagrow/subscribed/panes/SubscriptionPane";

export default function () {
    // create the route
    app.routes['flagrow-subscribed-configure-subscriptions'] = {path: '/flagrow/subscribed/configure', component: SubscriptionPane.component()};

    // bind the route we created to the three dots settings button
    app.extensionSettings['flagrow-subscribed'] = () => m.route(app.route('flagrow-subscribed-configure-subscriptions'));

    extend(AdminNav.prototype, 'items', items => {
        // add the Image Upload tab to the admin navigation menu
        items.add('flagrow-subscribed-configure-subscriptions', AdminLinkButton.component({
            href: app.route('flagrow-subscribed-configure-subscriptions'),
            icon: 'reply-all',
            children: 'Subscribed',
            description: app.translator.trans('flagrow-subscribed.admin.menu.description')
        }));
    });
}
