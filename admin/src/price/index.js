define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/price': {
                name: 'price',
                component: require('./content')
            }
        });

});
