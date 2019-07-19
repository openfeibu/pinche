define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/banner': {
                name: 'banner',
                component: require('./content')
            }
        });

});
