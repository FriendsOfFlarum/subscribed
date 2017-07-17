"use strict";

System.register("flagrow/subscribed/addSubscriptionPane", ["flarum/extend", "flarum/components/AdminNav", "flarum/components/AdminLinkButton", "flagrow/subscribed/panes/SubscriptionPane"], function (_export, _context) {
    "use strict";

    var extend, AdminNav, AdminLinkButton, SubscriptionPane;

    _export("default", function () {
        // create the route
        app.routes['flagrow-subscribed-configure-subscriptions'] = { path: '/flagrow/subscribed/configure', component: SubscriptionPane.component() };

        // bind the route we created to the three dots settings button
        app.extensionSettings['flagrow-subscribed'] = function () {
            return m.route(app.route('flagrow-subscribed-configure-subscriptions'));
        };

        extend(AdminNav.prototype, 'items', function (items) {
            // add the Image Upload tab to the admin navigation menu
            items.add('flagrow-subscribed-configure-subscriptions', AdminLinkButton.component({
                href: app.route('flagrow-subscribed-configure-subscriptions'),
                icon: 'reply-all',
                children: 'Subscribed',
                description: app.translator.trans('flagrow-subscribed.admin.menu.description')
            }));
        });
    });

    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
        }, function (_flarumComponentsAdminNav) {
            AdminNav = _flarumComponentsAdminNav.default;
        }, function (_flarumComponentsAdminLinkButton) {
            AdminLinkButton = _flarumComponentsAdminLinkButton.default;
        }, function (_flagrowSubscribedPanesSubscriptionPane) {
            SubscriptionPane = _flagrowSubscribedPanesSubscriptionPane.default;
        }],
        execute: function () {}
    };
});;
'use strict';

System.register('flagrow/subscribed/main', ['flarum/extend', 'flagrow/subscribed/addSubscriptionPane'], function (_export, _context) {
    "use strict";

    var extend, addSubscriptionPane;
    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
        }, function (_flagrowSubscribedAddSubscriptionPane) {
            addSubscriptionPane = _flagrowSubscribedAddSubscriptionPane.default;
        }],
        execute: function () {

            app.initializers.add('flagrow-subscribed', function (app) {
                addSubscriptionPane();
            });
        }
    };
});;
"use strict";

System.register("flagrow/subscribed/panes/SubscriptionPane", ["flarum/Component", "flarum/components/Switch", "flarum/components/Button", "flarum/utils/saveSettings"], function (_export, _context) {
  "use strict";

  var Component, Switch, Button, saveSettings, SubscriptionPane;
  return {
    setters: [function (_flarumComponent) {
      Component = _flarumComponent.default;
    }, function (_flarumComponentsSwitch) {
      Switch = _flarumComponentsSwitch.default;
    }, function (_flarumComponentsButton) {
      Button = _flarumComponentsButton.default;
    }, function (_flarumUtilsSaveSettings) {
      saveSettings = _flarumUtilsSaveSettings.default;
    }],
    execute: function () {
      SubscriptionPane = function (_Component) {
        babelHelpers.inherits(SubscriptionPane, _Component);

        function SubscriptionPane() {
          babelHelpers.classCallCheck(this, SubscriptionPane);
          return babelHelpers.possibleConstructorReturn(this, (SubscriptionPane.__proto__ || Object.getPrototypeOf(SubscriptionPane)).apply(this, arguments));
        }

        babelHelpers.createClass(SubscriptionPane, [{
          key: "init",
          value: function init() {}
        }, {
          key: "config",
          value: function config() {}
        }, {
          key: "view",
          value: function view() {
            return m('div', { className: 'Flagrow--Subscriptions' }, []);
          }
        }, {
          key: "updateSetting",
          value: function updateSetting(prop, setting, value) {
            saveSettings(babelHelpers.defineProperty({}, setting, value));

            prop(value);
          }
        }]);
        return SubscriptionPane;
      }(Component);

      _export("default", SubscriptionPane);
    }
  };
});