define(['./templates', 'app/basicvue','fileupload'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '宣传图',
                list: {
                    total: 0,
                    per_page: 10,
                    current_page: 1,
                    data: []
                },
                hasnext: false
            };
        },
        computed: {
            page_count: function() {
                return Math.ceil(this.list.total / this.list.per_page);
            }
        },
        ready: function(){
            var me = this;
            me.pageUser();
        },
        methods: {
            num:function(){
                var me = this;
                me.numcount = 0;
            },
            pageUser: function() {
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/banner/listBanner', {
                    page: me.list.current_page,
                    step: me.list.per_page
                }, function (res) {
                    layer.close(loadindex);
                    me.numcount = res.data.data.length;
                    if(res.success) {
                        me.list = res.data;
                    }
                }, 'json');
            },
            page: function($p) {
                var me = this;
                if($p > me.list.total) {
                    $p = me.list.total;
                }
                if($p < 1) {
                    $p = 1;
                }
                me.list.current_page = $p;
                me.pageUser();
            },
            remove:function(id){
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/banner/delete', {
                    id: id,
                }, function (res) {
                    layer.close(loadindex);
                    if(res.success) {
                        me.pageUser();
                    }
                }, 'json');
            },
            create:function(){
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/banner/create', {
                    title:"新增",
                    url:"NULL",
                    link:"",
                    sort:me.numcount? me.numcount + 1 : 1,
                    status:"0",
                    location:"1",
                    text :"新增"
                }, function (res) {
                    layer.close(loadindex);
                    if(res.success) {
                        me.pageUser();
                    }
                }, 'json');
            },
            update:function(id,title,url,link,sort,status,location,loadpage){
                var me = this;
                var loadindex = layer.load();
                var parameter = {
                    id:id,
                    title:title,
                    url:url,
                    link:link,
                    sort:sort,
                    status:status,
                    location:location
                };
                $.ajax({
                   type: 'POST',
                   url: '/carpool/banner/update',
                   data: parameter ,
                   dataType: 'json',
                   error:function(res){
                        layer.close(loadindex);
                        layer.msg("网络异常");
                   },
                   success: function(res){
                        layer.close(loadindex);
                        if(res.success) {
                            layer.close(loadpage);
                            me.pageUser();
                        }else{
                            label.msg(res.msg);
                        }
                   }
                });
            },
            read:function(id){
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/banner/read', {
                    id:id
                }, function (res) {
                     layer.close(loadindex);
                    if(res.success) {
                        var loadpage = layer.open({
                          type: 1  ,//Page层类型
                          area: ['400px', '500px'] , 
                          title: '编辑' ,
                          closeBtn: 1, //不显示关闭按钮
                          btn:["确定","取消"],
                          shade: 0.6  ,//遮罩透明度
                          // maxmin: true  ,//允许全屏最小化
                          anim: 1 ,//0-6的动画形式，-1不开启
                          content: '<ul class="layui-form" lay-filter="edit-form">'+
                                       ' <li class="layui-form-item">'+
                                            '<label class="layui-form-label">标题：</label>'+
                                            '<div class="layui-input-block">'+
                                              '<input type="text" name="" id="title" value="'+res.data.title+'" placeholder="请输入" autocomplete="off" class="layui-input">'+
                                            '</div>'+
                                       ' </li>'+
                                       ' <li class="layui-form-item">'+
                                            '<label class="layui-form-label">顺序号：</label>'+
                                            '<div class="layui-input-block">'+
                                              '<input type="text" name="" id="sort" value="'+res.data.sort+'" placeholder="请输入" autocomplete="off" class="layui-input">'+
                                            '</div>'+
                                       ' </li>'+
                                       ' <li class="layui-form-item">'+
                                            ' <label class="layui-form-label">状态：</label>'+
                                            ' <div class="layui-input-block" id="status">'+
                                              ' <input type="radio" name="status" value="0" title="停用" class="layui-radio"><span class="layui-span" >停用</span>'+
                                              ' <input type="radio" name="status" value="1" title="启用" class="layui-radio"><span class="layui-span">启用</span>'+
                                            ' </div>'+
                                       ' </li>'+
                                       ' <li class="layui-form-item">'+
                                            ' <label class="layui-form-label">显示位置：</label>'+
                                            ' <div class="layui-input-block" id="location">'+
                                            '<select style="width:90%;" id="sel_location">'+
                                            '<option value ="1">首页</option>'+
                                            '<option value ="2">发布</option>'+
                                            '</select>'+
                                            ' </div>'+
                                       ' </li>'+
                                       ' <li class="layui-form-item">'+
                                            ' <label class="layui-form-label">图片：</label>'+
                                            ' <div class="layui-input-block">'+
                                                '<img class="layui-img" id="fileimg" src="'+res.data.url+'"/>'+
                                            ' </div>'+
                                       ' </li>'+
                                       ' <li class="layui-form-item">'+
                                            ' <label class="layui-form-label">上传图片(建议尺寸750*240px)</label>'+
                                            ' <div class="layui-input-block">'+
                                                ' <input type="file" id="filebtn"   name="file"  class="layui-file">'+
                                            ' </div>'+
                                       ' </li>'+
                                       ' <li class="layui-form-item">'+
                                            '<label class="layui-form-label">链接地址：</label>'+
                                            '<div class="layui-input-block">'+
                                              '<input type="text" name="" id="link" value="'+res.data.link+'" placeholder="请输入链接地址" autocomplete="off" class="layui-input">'+
                                            '</div>'+
                                       ' </li>'+
                                    '</ul>',
                            success:function(content){
                                    $("input:radio[name='status']").eq(res.data.status).attr("checked",'checked');
                                    $("#sel_location").val(res.data.location);
                                    me.readimg();
                            },
                            btn1:function(content){
                                    var id = res.data.id;
                                    var title = $("#title").val().trim(); 
                                    var url = $("#fileimg").attr("src");
                                    var link = $("#link").val().trim(); 
                                    var sort = $("#sort").val().trim();
                                    var status = $("input:radio[name='status']:checked").val();
                                    var location = $("#sel_location").val();
                                    me.update(id,title,url,link,sort,status,location,loadpage);
                            }
                        });   
                    }
                }, 'json');
            },
            readimg:function(){
                var me = this;
                var upload = $('#filebtn');
                upload.attr('data-url', '/carpool/upload/uploadPic');
                upload.fileupload({
                    dataType:'json',
                    done: function(e, data) {
                       $("#fileimg").attr("src",data.result.data);
                       console.log(data.result.data);
                    },
                    progressall: function(e, data) {
                        //
                    },
                    submit: function(e, data) {
                        console.log('11');
                    }
                });
            }
        }
    });

});
