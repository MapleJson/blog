layui.use(["jquery", "form", "layedit", "flow"], function () {
    var t = layui.form,
        n = layui.jquery,
        i = layui.layedit,
        r;
    r = i.build("remarkEditor", {
        height: 150,
        tool: ["face", "|", "link"]
    });
    t.verify({
        content: function (t) {
            if (t = n.trim(i.getContent(r)), t == "") return "请输入内容";
            i.sync(r)
        },
        replyContent: function (n) {
            if (n == "") return "请输入内容"
        }
    });
    t.on("submit(addMessage)", function (t) {
        var i = layer.load(1);
        return n.ajax({
            type: "POST",
            url: "/message",
            data: t.field,
            success: function (n) {
                layer.close(i);
                n.code === 200 ? (layer.msg(n.msg, {
                    icon: 6
                }), setTimeout(function () {
                    location.reload(!0)
                }, 500)) : n.msg != "" ? layer.msg(n.msg, {
                    icon: 5
                }) : layer.msg("程序异常，请重试或联系作者", {
                    icon: 5
                })
            },
            error: function (e) {
                layer.close(i);
                if ("Unauthenticated." === e.responseJSON.message) {
                    layer.msg("请先登录", {
                        icon: 5
                    })
                } else {
                    layer.msg("请求异常", {
                        icon: 2
                    })
                }
            }
        }), !1
    });
    n(".message-list").on("click", ".btn-reply", function () {
        var i = n(this).data("targetid"),
            r = n(this).data("targetname"),
            t = n(this).parent("p").parent().siblings(".replycontainer");
        n(this).text() === "回复" ?
            (t.find("textarea").attr("placeholder", "回复【" + r + "】"),
                n(this).parents(".message-list").find(".replycontainer").addClass("layui-hide"),
                t.removeClass("layui-hide"),
                t.find('input[name="targetId"]').val(i),
                t.find('input[name="targetUser"]').val(r),
                n(this).parents(".message-list").find(".btn-reply").text("回复"),
                n(this).text("收起"))
            : (t.addClass("layui-hide"),
                t.find('input[name="targetId"]').val(0),
                t.find('input[name="targetUser"]').val(''),
                n(this).text("回复"));
    });
});
