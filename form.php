<?php
/**
 * Created by IntelliJ IDEA.
 * User: imo
 * Date: 16/3/10
 * Time: 下午7:24
 */
header("Content-type: text/html; charset=UTF-8");
include('config.php');
include('lib/teegon.php');

$param['order_no'] = substr(md5(time().print_r($_SERVER,1)), 0, 24); //订单号
$param['channel'] = 'alipay';
$param['return_url'] = 'http://www.baidu.com';
$param['amount'] = 0.01;
$param['subject'] = "测试";
$param['metadata'] = "";
$param['notify_url'] = 'http://www.baidu.com';//支付成功后天工支付网关通知
$param['client_ip'] = '127.0.0.1';
$param['client_id'] = TEE_CLIENT_ID;

$srv = new TeegonService(TEE_API_URL);
$sign = $srv->sign($param);
$param['sign'] = $sign;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支付</title>
</head>
<body>

<form action="<?php echo TEE_API_URL?>charge/pay" method="post">
    <input type="text" name="order_no" value="<?php echo $param['order_no']?>">
    <br>
    <input type="text" name="channel" value="<?php echo $param['channel']?>">
    <br>
    <input type="text" name="amount" value="<?php echo $param['amount']?>">
    <br>
    <input type="text" name="subject" value="<?php echo $param['subject']?>">
    <br>
    <input type="text" name="metadata" value="<?php echo $param['metadata']?>">
    <br>
    <input type="text" name="client_ip" value="<?php echo $param['client_ip']?>">
    <br>
    <input type="text" name="return_url" value="<?php echo $param['return_url']?>">
    <br>
    <input type="text" name="notify_url" value="<?php echo $param['notify_url']?>">
    <br>
    <input type="text" name="sign" value="<?php echo $param['sign']?>">
    <br>
    <input type="text" name="client_id" value="<?php echo $param['client_id']?>">
    <br>
    <input type="submit" value="支付">
</form>

</body>
</html>