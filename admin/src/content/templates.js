define([],function() {var  templates={}; var baseUrl='./src/content/';return{getHtml:function(path){if(templates[path])return templates[path];var html=$.ajax({url:baseUrl+path,async:!1}).responseText;templates[path]=html;return html}}});
