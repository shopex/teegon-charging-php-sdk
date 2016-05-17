<?php
include('config.php');
include('lib/teegon.php');
$srv = new TeegonService(TEE_API_URL);

$rst = $srv->post('v1/blink/token', array(
        'client_id'=>TEE_CLIENT_ID,
        'client_secret'=>TEE_CLIENT_SECRET,
    ));

$rst = json_decode($rst);
$token = $rst->result;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>monitor</title>

    <style>
    body{background:#000; color:#ccc;}
    .cnt{color:#ff0;}
    .money{color:#0ff;}
    #box-fake{width:1280px;height:720px;border:1px solid #000}
    .fb{background: #000; color:#fff;}
    #last{font-size:128px; margin: 50px 0 0 20px}
    #today{font-size:64px; position: absolute;top:0;right:50px;}
    #today h1{font-size:64px;}
    #history{padding:10px;font-size:42px;position: absolute;bottom:20px;width:100%}
    #history label{margin-left: 2em}
    #history{white-space: nowrap; height: 1em;background: rgba(255,255,255,0.1)}
    </style>

    <script src="//charging.teegon.com/static/js/jquery.min.js"></script>
    <script src="//charging.teegon.com/jslib/t-tools.min.js"></script>
    <script>

    setTimeout(window.location.reload, 1000*60*60);

    var d_c=0;
    var d_a=0;
    var w_c=0;
    var w_c=0;
    var m_c=0;
    var m_a=0;
    var t_c=0;
    var t_a=0;

    $(function(){
        tee.blink({
            "token":"<?php echo $token; ?>",
            "playsound":"https://charging.teegon.com/static/blink/s1.wav"
        }).init(function(rst){  //加载历史信息
            console.info("init", rst);
            d_c=rst.result.day.count;
            d_a=rst.result.day.amount;
            w_c=rst.result.week.count;
            w_a=rst.result.week.amount;
            m_c=rst.result.month.count;
            m_a=rst.result.month.amount;
            $('#p_d_c').html(rst.result.yesterday.count+'笔');
            $('#p_d_a').html("&yen;"+rst.result.yesterday.amount);
            $('#p_w_c').html(rst.result.lastweek.count+'笔');
            $('#p_w_a').html("&yen;"+rst.result.lastweek.amount);
            $('#p_m_c').html(rst.result.lastmonth.count+'笔');
            $('#p_m_a').html("&yen;"+rst.result.lastmonth.amount);
            t_c=rst.result.total.count;
            t_a=rst.result.total.amount;
        }).handle(function(rst){ //每两秒轮训新订单
            if(rst.result.last[0]){
                var d = new Date();
                $('#last-amount').html("&yen;"+rst.result.last[0].amount);
                $('#last-time').html(d.getHours()+":"+d.getMinutes());
            }
            if(rst.result.count>0){
                window.document.title = "[" + rst.result.amount + "]";
                d_c+=rst.result.count;
                d_a+=rst.result.amount;
                w_c+=rst.result.count;
                w_a+=rst.result.amount;
                m_c+=rst.result.count;
                m_a+=rst.result.amount;
                t_c+=rst.result.count;
                t_a+=rst.result.amount;
            }
            $('#s_d_c').html(d_c+"笔");
            $('#s_d_a').html("&yen;"+d_a.toFixed(2));
            $('#s_w_c').html(w_c+"笔");
            $('#s_w_a').html("&yen;"+w_a.toFixed(2));
            $('#s_m_c').html(m_c+"笔");
            $('#s_m_a').html("&yen;"+m_a.toFixed(2));
            $('#t_c').html(t_c+"笔");
            $('#t_a').html("&yen;"+t_a.toFixed(2));
        });
    });
    </script>
</head>

<body>
    <div id="box">
        <div>
            <div id="last">
                <div style="font-size:40px;padding:10px">Last:<span style="padding-left:30px" id="last-time"></span></div>
                <div id="last-amount" style="color:#fff">0</div>
            </div>
        </div>

        <div id="today">
            <h1>今日</h1>
            <div id="s_d_c" class="cnt">0</div>
            <div id="s_d_a" class="money">0</div>
        </div>

        <marquee scrollamount="10" id="history">
                <label>昨日: <span id="p_d_c" class="cnt"></span> / <span id="p_d_a" class="money"></span></label>
                <label>总计: <span id="t_c" class="cnt"></span> / <span id="t_a" class="money"></span></label>
                <label>本周: <span id="s_w_c" class="cnt"></span> / <span id="s_w_a" class="money"></span></label>
                <label>上周: <span id="p_w_c" class="cnt"></span> / <span id="p_w_a" class="money"></span></label>
                <label>本月: <span id="s_m_c" class="cnt"></span> / <span id="s_m_a" class="money"></span></label>
                <label>上月: <span id="p_m_c" class="cnt"></span> / <span id="p_m_a" class="money"></span></label>
        </marquee>
    </div>
</body>


<script>

</script>
</html>
