define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/content': {
                name: 'content',
                component: require('./content')
            }
        });

});
