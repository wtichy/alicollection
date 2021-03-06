<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>阿里巴巴采集</title>
    <!-- <link rel="stylesheet" type="text/css" href="/css/comment.css"> -->
    <link rel="stylesheet" type="text/css" href="/bower_components/Semantic-UI/dist/semantic.min.css">

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/Semantic-UI/dist/semantic.min.js"></script>
    <style type="text/css">
    .huge {
        width: 500px;
        margin-top: 10px;
    }
    .column {
        margin-top: 30px;
        max-width: 500px;
    }
    .searchIcon{

    }
    .teal {
        color: #00b5ad
    }
    .mt20 {
        margin-top: 20px
    }
    .hide {
        display:none;
    }
  </style>
</head>

<body>
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <form class="ui form">
                <div class="searchIcon">
                    <i class="paw icon huge teal"></i><b class="teal">阿里巴巴采集</b>
                </div>
                <div class="ui huge action left icon input">
                    <i class="search icon"></i>
                    <input type="text" name="keys" placeholder="输入关键字..." value="">
                    <div class="ui teal button" id="keySearch">Search</div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
    $(function(){
        $(document).on('click', '#keySearch', function(){
            $.ajax({
                url : '/reptile/result',
                type : 'GET',
                data : {keys : $('input[name="keys"]').val()},
                dataType : 'json',
                beforeSend: function () {
                    //异步请求时loading出现
                    $(".loading").removeClass('hide');
                },
                success : function(res) {
                    if (res.status == '200') {
                        $("tbody").empty();
     
                        var html = "";
                        $.each(res.data, function(i, val) {
                            html += "<tr><td>"+ (parseInt(i)+1) +"</td><td><a href="+ res.data[i]['result']['link'] +" target='_blank'>" + res.data[i]['result']['title'] + "</a></td>";
                            html += "<td>" + res.data[i]['result']['keyword'] + "</td>";
                            html += "<td>" + res.data[i]['result']['price'] + "</td></tr>";
                        });

                        $("tbody").append(html);
                        // userIds
                        $("input[name='userIds']").val(res.userIds);
                        $("#export").removeClass('disabled');
                    }
                },
                error : function() {
                    alert('服务器出错了');
                },
                complete : function () {
                    $(".loading").addClass('hide');
                },
            });
        });
        
        $(document).on('click', '#export', function(){
            window.location.href = "/result/export?userIds=" + $('input[name="userIds"]').val()+"&keys=" + $('input[name="keys"]').val();
        });
    });
    </script>

    <div class="ui container mt20">
        <table class="ui celled table">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>Title （标题）</th>
                    <th>Keywords （关键词</th>
                    <th>Price <i class=" icon"></i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="center" style="text-align:center">
                        <p>亲！还没有数据哦！</p>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        <!-- <div class="ui floated right pagination menu">
                            <a class="icon item disabled"><i class="left chevron icon"></i></a>
                            <a class="item active">1</a>
                            <a class="item">2</a>
                            <a class="item">3</a>
                            <a class="item">4</a>
                            <a class="icon item"><i class="right chevron icon"></i></a>

                        </div> -->
                        <button class="ui orange button submit tiny action disabled" id="export">导出Excel</button>
                        <input type="hidden" name="userIds" />
                    </th>
                </tr>
            </tfoot>
            <div class="loading hide">
                <div class="ui active inverted dimmer">
                    <div class="ui text loader">采集中...</div>
                </div>
            </div>
        </table>
    </div>

    <!--操作提示框-->
    <div class="ui small action modal">
        <div class="header">提示框</div>
        <div class="content">
            <p>没有任何数据~</p>
        </div>
        <div class="actions">
            <div class="ui red approve button"><i class="checkmark icon"></i>确定</div>
            <!-- <div class="ui cancel button">取消</div> -->
        </div>
    </div>
    <!--//提示框-->
</body>
</html>