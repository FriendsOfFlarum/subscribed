<?php

namespace Flagrow\Subscribed\Listeners;

use Flarum\Event\PrepareApiAttributes;
use Flarum\Event\UserWasRegistered;
use Flarum\Event\UserWillBeSaved;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class GlobalSubscriptionSettings
{
    /**
     * @var SettingsRepositoryInterface
     */
    private $settings;

    function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserWillBeSaved::class, [$this, 'save']);
        $events->listen(PrepareApiAttributes::class, [$this, 'inject']);

        $events->listen(UserWasRegistered::class, [$this, 'setDefaults']);
    }

    public function save(UserWillBeSaved $event)
    {
        if (!$event->actor->isAdmin()) {
            return;
        }

        $preferences = Arr::get($event->data, 'attributes.preferences', []);

        foreach ($preferences as $key => $value) {
            if (!$this->isSubscribedSetting($key)) {
                unset($preferences[$key]);
            }
        }

        if (empty($preferences)) {
            return;
        }

        foreach ($preferences as $setting => $value) {
            $setting = sprintf("flagrow.subscribed.%s", $setting);
            $this->settings->set($setting, $value);
        }
    }

    public function inject(PrepareApiAttributes $event)
    {
        if (!$event->actor->isAdmin()) {
            return;
        }

        $preferences = array_keys($event->actor->preferences);

        foreach ($preferences as $preference) {
            if (Str::startsWith($preference, 'notify_')) {
                foreach (['defaults', 'forced'] as $append) {
                    $setting = sprintf("flagrow.subscribed.%s_%s", $preference, $append);

                    $event->attributes[$setting] = $this->settings->get($setting, false) == '1';
                }
            }
        }
    }

    public function setDefaults(UserWasRegistered $event)
    {
        foreach ($this->settings->all() as $setting => $value) {

            if (!Str::startsWith($setting, 'flagrow.subscribed.')) {
                continue;
            }

            if (!preg_match('/^flagrow\.subscribed\.(?<set>.*)_defaults$/', $setting, $m)) {
                continue;
            }

            $setting = $m['set'];

            if ($event->user->getPreference($setting, null) === null) {
                $event->user->setPreference($setting, $value);
            }
        }
    }

    protected function isSubscribedSetting($setting)
    {
        return preg_match('/^notify_[^_]+_[^_]+_(forced|defaults)$/', $setting);
    }
}
