layui.use(["jquery", "flow"], function () {
    var $ = layui.jquery,
        f = layui.flow;
    //按屏加载图片
    f.load({
        elem: '#LAY_whisper_load' //流加载容器
        , isAuto: false
        , done: function (page, next) { //加载下一页
            $.get(
                '/loadWhisper'
                , {
                    page: page
                    , limit: 10
                }
                , function (data) {
                    var lis = [];
                    layui.each(data.data, function (index, item) {
                        var html = '';
                        html += "<li class=\"layui-timeline-item\">";
                        html += "<i class=\"layui-icon layui-timeline-axis\"></i>";
                        html += "<div class=\"layui-timeline-content layui-text\">";
                        html += "<h3 class=\"layui-timeline-title\">" + item.created_at + "  --  " + item.author + "</h3>";
                        html += "<p>" + item.content + "</p>";
                        html += "</div>";
                        html += "</li>";
                        lis.push(html);
                    });
                    if (page == data.pages) {
                        var end = '<li class="layui-timeline-item last-before">' +
                            '    <i class="layui-icon layui-timeline-axis"></i>' +
                            '    <div class="layui-timeline-content layui-text">' +
                            '      <div class="layui-timeline-title">我们的博客诞生了</div>' +
                            '    </div>' +
                            '  </li>';
                        lis.push(end);
                    }
                    next(lis.join(''), page < data.pages);
                }
                , 'json'
            );
        }
    });
});