define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/pay': {
                name: 'pay',
                component: require('./content')
            }
        });

});
