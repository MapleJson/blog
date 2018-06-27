layui.use(["jquery", "form", "layedit", "flow"], function () {
    var t = layui.form,
        n = layui.jquery,
        i = layui.layedit,
        f = layui.flow,
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
    n(".btn-reply").on("click", function () {
        var i = n(this).data("targetid"),
            r = n(this).data("targetname"),
            t = n(this).parent("p").parent().siblings(".replycontainer");
        n(this).text() === "回复" ?
            (t.find("textarea").attr("placeholder", "回复【" + r + "】"),
                n(this).parents(".news_pl").find(".replycontainer").addClass("layui-hide"),
                t.removeClass("layui-hide"),
                t.find('input[name="targetId"]').val(i),
                t.find('input[name="targetUser"]').val(r),
                n(this).parents(".news_pl").find(".btn-reply").text("回复"),
                n(this).text("收起"))
            : (t.addClass("layui-hide"),
                t.find('input[name="targetId"]').val(0),
                t.find('input[name="targetUser"]').val(''),
                n(this).text("回复"));
    });

    n.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': n('meta[name="csrf-token"]').attr('content')
        }
    });
    //按屏加载图片
    f.load({
        elem: '#LAY_blog_load' //流加载容器
        , isAuto: false
        , done: function (page, next) { //加载下一页
            n.get(
                '/loadBlog'
                , {
                    page: page
                    , limit: 5
                }
                , function (data) {
                    var lis = [];
                    layui.each(data.data, function (index, item) {
                        var html = '';
                        html += "<li class=\"layui-anim\" data-anim=\"layui-anim-fadein\">";

                        if (item.img) {
                            html += "                    <span class=\"blogpic\">";
                            html += "                    <a href=\"/blog/info/" + item.id + "\">";
                            html += "                        <img src=\"" + item.img + "\">";
                            html += "                    </a>";
                            html += "                </span>";
                        }

                        html += "                <h3 class=\"blogtitle\">";
                        html += "                    <a href=\"/blog/info/" + item.id + "\">" + item.title + "</a>";
                        html += "                </h3>";
                        html += "                <div class=\"bloginfo\">";
                        html += "                    <p>" + item.summary + "</p>";
                        html += "                </div>";
                        html += "                <div class=\"autor\">";
                        html += "                    <span class=\"lm\">";

                        layui.each(item.tags, function (i, t) {
                            html += "                            <i title=\"" + t + "\" class=\"layui-badge\">" + t + "</i>";
                        });

                        html += "                    </span>";
                        html += "                    <span class=\"dtime\">" + item.created_at + "</span>";
                        html += "                    <span class=\"read\"><i class=\"fa fa-eye\"></i> " + item.read + "</span>";
                        html += "                    <span class=\"comments\"><i class=\"fa fa-comments\"></i> " + item.comments + "</span>";
                        html += "                    <span class=\"readmore\"><a href=\"/blog/info/" + item.id + "\">阅读原文</a></span>";
                        html += "                </div>";
                        html += "            </li>";
                        lis.push(html);
                    });
                    next(lis.join(''), page <= data.pages);
                }
                , 'json'
            );
        }
    });
});