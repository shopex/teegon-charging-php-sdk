# 统一收银

## 页面代码

```html
    <button id="pb">支付宝支付</button>
    <script>
    $('#pb').click(function(){
        $.ajax({
            data: "goods_id=123131&action=pay&channel=alipay&return="+window.location,
            method:'post'
        }).done(tee.charge);
    });
    </script>
```

## PHP代码

```php
    $srv = new TeegonService(TEE_API_URL);
    $rst = $srv->post('v1/charge/', array(
            'client_id'=>TEE_CLIENT_ID,
            'client_secret'=>TEE_CLIENT_SECRET,
            'amount'=>0.01,
            'return_url'=>$_POST['return'],
            'channel'=>$_POST['channel'],
            'order_no'=>$order_id,
            'subject'=>'测试支付',
        ));
```
