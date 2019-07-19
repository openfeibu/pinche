define(['../templates', 'app/basicvue'], function(templates, BasicVue){

    Vue.component('admin-topwelcome', {
        template: templates.getHtml('tpl/topwelcome.html'),
        data: function () {
            return {
                username: '',
            };
        },
        ready: function(){
            if(typeof sessionStorage.userinfo !== 'undefined'){
                this.username = JSON.parse(decodeURIComponent(sessionStorage.userinfo)).name;
            }
        },
        methods: {

        }
    });

});
