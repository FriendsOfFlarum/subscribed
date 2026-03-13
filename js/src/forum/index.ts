import app from 'flarum/forum/app';
import extendNotificationGrid from './extenders/extendNotificationGrid';

export { default as extend } from './extend';

app.initializers.add('fof-subscribed', () => {
  extendNotificationGrid();
});
