define([],function() {var  templates={}; var baseUrl='./src/changepswd/';return{getHtml:function(path){if(templates[path])return templates[path];var html=$.ajax({url:baseUrl+path,async:!1}).responseText;templates[path]=html;return html}}});