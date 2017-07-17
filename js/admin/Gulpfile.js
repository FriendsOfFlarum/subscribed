var gulp = require('flarum-gulp');

gulp({
    modules: {
        'flagrow/subscribed': [
            'src/**/*.js'
        ]
    }
});
