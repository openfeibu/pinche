define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/changepswd': {
                name: 'changepswd',
                component: require('./content')
            }
        });

});
