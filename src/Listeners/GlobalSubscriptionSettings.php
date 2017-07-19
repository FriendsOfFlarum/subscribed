<?php

namespace Flagrow\Subscribed\Listeners;

use Flarum\Api\Serializer\ForumSerializer;
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
        $events->listen(UserWillBeSaved::class, [$this, 'forced']);
    }

    public function forced(UserWillBeSaved $event)
    {
        foreach ($this->settings->all() as $key => $value) {

            if (!Str::startsWith($key, 'flagrow.subscribed.')) {
                continue;
            }

            $forced = $this->isSubscribedSetting($key, 'forced');

            if (!$forced) {
                continue;
            }

            $event->user->setPreference($forced, $value);
        }
    }

    public function save(UserWillBeSaved $event)
    {
        if (!$event->actor->isAdmin()) {
            return;
        }

        $preferences = Arr::get($event->data, 'attributes.preferences', []);

        foreach ($preferences as $key => $value) {

            // Drop any submitted value actually a user preference.
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
        if (!$event->actor || !$event->actor->isAdmin() || !$event->isSerializer(ForumSerializer::class)) {
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
        foreach ($this->settings->all() as $key => $value) {

            if (!Str::startsWith($key, 'flagrow.subscribed.')) {
                continue;
            }

            $forced = $this->isSubscribedSetting($key, 'forced');
            $default = $this->isSubscribedSetting($key, 'defaults');

            if (!$forced && !$default) {
                continue;
            }

            $event->user->setPreference($forced ? $forced : $default, $value);
        }

        $event->user->save();
    }

    protected function isSubscribedSetting($setting, $type = null)
    {
        if ($type === null) {
            $type = 'forced|defaults';
        }

        $matched = preg_match('/^(flagrow\.subscribed\.)?(?<set>notify_.*)_('. $type .')$/', $setting, $m);

        return $matched !== 1 ? false : $m['set'];
    }
}
