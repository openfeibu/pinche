define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/user': {
                name: 'user',
                component: require('./content')
            }
        });

});
