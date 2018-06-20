layui.use(['jquery', 'layer', 'form'], function () {
    var $ = layui.jquery
        , layer = layui.layer
        , form = layui.form;
    var pro;
    $(".apply-link").on('click', function () {
        pro = layer.open({
            id: 'LAY_layuipro' //设定一个id，防止重复弹出
            , type: 1 //此处以iframe举例
            , title: '当你选择该窗体时，即会在最顶端'
            , area: ['90%', '350px']
            , shade: 0.5
            , shadeClose: true
            , offset: ['250px', '5%']
            , maxmin: true
            , content: $('#applyLinks')
            , zIndex: layer.zIndex
            , success: function (layero) {
                layer.setTop(layero);
            }
        });
    });

    form.on("submit(applyLink)", function (obj) {
        var i = layer.load(1);
        return $.ajax({
            type: "POST",
            url: "/links",
            data: obj.field,
            success: function (d) {
                layer.close(i);
                d.code === 200 ? (layer.close(pro), layer.msg(d.msg, {
                    icon: 6
                }), setTimeout(function () {
                    location.reload(!0)
                }, 1000)) : d.msg != "" ? layer.msg(d.msg, {
                    icon: 5
                }) : layer.msg("程序异常，请重试或联系作者", {
                    icon: 5
                })
            },
            error: function () {
                layer.close(i);
                layer.close(pro)
                layer.msg("请求异常", {
                    icon: 2
                })
            }
        }), !1
    });
});