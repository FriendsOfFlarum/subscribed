import Component from "flarum/Component";
import Switch from "flarum/components/Switch";
import Button from "flarum/components/Button";
import saveSettings from "flarum/utils/saveSettings";

export default class SubscriptionPane extends Component {

    /**
     * Sets up the component.
     */
    init() {
    }

    /**
     * Configures the component.
     */
    config() {
    }

    /**
     * Generates the component view.
     *
     * @returns {*}
     */
    view() {
        return m('div', {className: 'Flagrow--Subscriptions'}, [

        ])
    }

    /**
     * Updates setting in database.
     * @param prop
     * @param setting
     * @param value
     */
    updateSetting(prop, setting, value)
    {
        saveSettings({
            [setting]: value
        });

        prop(value)
    }
}
