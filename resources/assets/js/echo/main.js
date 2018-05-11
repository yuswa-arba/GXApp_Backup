
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.echo = new Echo({
    broadcaster: 'socket.io',
    connector: 'socket.io',
    host: window.location.hostname + ':6001',
    namespace: 'App'
})


/*
* Make sure to only put things in here that is global, means
* its included in all page, otherwise create a specific file and
* include it in the related page
* */


/* INIT ECHO LISTENERS */

// require('./notification/main')