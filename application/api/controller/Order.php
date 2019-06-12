<?php
namespace app\api\controller;

class Order extends Common
{
	//下单
    public function submitOrder(){
        if($this->check_token()){
        	$cartId = input('cartId');
        	$addressId = input('addressId');
        	$goodsTotalPrice = input('goodsTotalPrice');
            $openid = input('openid'); 
            $user_id = $this->getUserId($openid);
            if($user_id){
                $res = $this->doOrder($user_id, $cartId, $addressId, $goodsTotalPrice);      //数据写入数据库
                $res['order'] = db('order')->where('out_trade_no_submit',$res['out_trade_no_submit'])->find();
                //准备发起微信支付
                $res['data'] = $this->getWxpayInfo($res['out_trade_no_submit']);
                $res['code'] = 200;
                $res['msg'] = '下单完成';

                // db('cart')->where('id','in',$cartId)->delete();
                return json($res);
            }else{
                return json(['code'=>400, 'msg'=>'重新登录']);
            }
        }else{
            return json(['code'=>400, 'msg'=>'重新登录']);
        }
    }

    //订单列表再次发起微信支付
    public function getWxpayData(){
    	if($this->check_token()){
            $openid = input('openid'); 
            $uid = $this->getUserId($openid);
            $orderId = input('orderId');
            if($uid){
            	$outTradeNoSubmit = $this->outTradeNo();   
            	db('order')->where('id',$orderId)->update(['out_trade_no_submit'=>$outTradeNoSubmit]);
            	$orderRes = $this->getWxpayInfo($outTradeNoSubmit);
                return json(['code'=>200, 'msg'=>'获取数据成功', 'data'=>$orderRes]);
            }else{
                return json(['code'=>400, 'msg'=>'重新登录']);
            }
        }else{
            return json(['code'=>400, 'msg'=>'重新登录']);
        }
    }

    //
    public function getWxpayInfo($outTradeNoSubmit){
    	//展示订单仅以下单商品中价格最高的一个
    	$order = db('order')->where('out_trade_no_submit',$outTradeNoSubmit)->find();
    	$goodsId = db('orderGoods')->where('order_id',$order['id'])->order('goods_price DESC')->limit(1)->value('goods_id');
    	$orderBody = db('goods')->where('id',$goodsId)->value('goods_name');
    	$tradeNo = $outTradeNoSubmit;
    	$totalFee = $order['goods_total_price']*100;
    	$openid = db('user')->where('id',$order['user_id'])->value('openid');
    	//调用统一下单
    	// dump($totalFee); die;
    	$response = $this->prePay($orderBody , $tradeNo, $totalFee, $openid);
    	// dump($response); die;
    	$wxData = $this->wxPay($response['prepay_id']);
    	$data['wxData'] = $wxData;
    	$data['goodsTotalPrice'] = $totalFee;
    	return $data;
    }

    //微信支付
    public function wxPay($prepayId){
    	$data['appId'] = config('APPID');
        $data['nonceStr'] = $this->getRandChar(32);
        $data['package'] = "prepay_id=".$prepayId;
        $data['signType'] = 'MD5';
        $data['timeStamp'] = time();
        $data['sign'] = $this->getSign($data);
        return $data;
    }

    //统一下单调用
    public function prePay($orderBody, $tradeNo, $totalFee, $openid){
    	$url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    	$notify_url = config('WXPAY.NOTIFY_URL');
    	$nonce_str = $this->getRandChar(32);
    	$data['appid'] = config('WXPAY.APPID');
    	$data['mch_id'] = config('WXPAY.MCHID');
        $data['nonce_str'] = $nonce_str;
        $data['body'] = $orderBody;
        $data['out_trade_no'] = $tradeNo;
        $data['total_fee'] = $totalFee;
        $data['spbill_create_ip'] = $this->get_client_ip();    // 获取当前服务器的IP
        $data['notify_url'] = $notify_url;
        $data['trade_type'] = 'JSAPI';
        $data['openid'] = $openid;
        $data['sign'] = $this->sign($data);
        $xml = $this->arrayToXml($data);
        $response = $this->postXmlCurl($xml, $url);
        return $this->xmlstr_to_array($response);
    }

    //写入记录
    public function doOrder($user_id, $cartId, $addressId, $goodsTotalPrice){
    	$address = db('address')->find($addressId);
    	$data = array(
    		'out_trade_no' => $this->outTradeNo(),
    		'out_trade_no_submit' => $this->outTradeNo(),
    		'user_id' => $user_id,
    		'address' => $address['address'],
    		'shr_name' => $address['address_name'],
    		'phone' => $address['phone']
    		);
    	//订单id
    	$orderId = db('order')->insertGetId($data);          //添加信息到订单表并且返回订单id
    	//处理订单商品表
    	$cartList = db('cart')->where('id','in',$cartId)->select();
    	//循环把购买的信息添加到订单-商品表
    	$goods = db('goods');
    	foreach ($cartList as $k => $v) {
    		$data = array(
    			'order_id' => $orderId,
    			'goods_id' => $v['goods_id'],
    			'goods_num' => $v['goods_num'],
    			'goods_price' => $goods->where('id',$v['goods_id'])->value('shop_price')
    			);
    		db('orderGoods')->insert($data);
    	}
    	 return array('code'=>200, 'msg'=>'下单成功', 'out_trade_no_submit'=>$data['out_trade_no_submit']);
    }

    //订单编号获取
    public function outTradeNo(){
    	$order = db('order');
    	while (true) {
    		$outTradeNo = time()+rand(1000,9999);
    		$countOutTradeNo = $order->where('out_trade_no',$outTradeNo)->count();
    		$countOutTradeNoSubmit = $order->where('out_trade_no_submit',$outTradeNo)->count();
    		if(!($countOutTradeNo || $countOutTradeNoSubmit)){
    			break;
    		}
    	}
    	return $outTradeNo;
    }


    //订单列表数据获取
    public function getOrderList(){
        if($this->check_token()){
            $openid = input('openid'); 
            $uid = $this->getUserId($openid);
            $page = input('page',1);
            $status = input('status','all');
            if($uid){
            	$map=[];
                switch ($status) {
                	case 'waitpay':
                		$map['order_status'] = 0;
                		break;
                	case 'waitsent':
                		$map['order_status'] = 1;
                		break;
                	case 'waitreceive':
                		$map['order_status'] = 2;
                		break;
                	case 'finish':
                		$map['order_status'] = 3;
                		break;
                	default:
                		# code...
                		break;
                }
                $map['user_id'] = $uid;
                $config=['page'=>$page,'list_rows'=>5];
                $orderRes = db('order')->where($map)->order('id DESC')->paginate(null,false,$config);
                foreach ($orderRes as $k => $v) {
                	$goodsId = db('orderGoods')->where('order_id',$v['id'])->order('goods_price DESC')->limit(1)->value('goods_id');
                	$goodsObj = model('goods')->field('thumb,goods_name,shop_price')->find($goodsId);
                	$goodsArr = $goodsObj->toArray();
                	$orderRes[$k] = array_merge($goodsArr,$v);
                }
                return json(['code'=>200, 'msg'=>'获取数据成功', 'data'=>$orderRes]);

            }else{
                return json(['code'=>400, 'msg'=>'重新登录']);
            }
        }else{
            return json(['code'=>400, 'msg'=>'重新登录']);
        }
    }

    //取消订单
    public function orderCancel(){
    	if($this->check_token()){
            $openid = input('openid'); 
            $uid = $this->getUserId($openid);
            $id = input('id');
            if($uid){
            	db('order')->where('id',$id)->setField('order_status',4);
                return json(['code'=>200, 'msg'=>'订单取消成功']);

            }else{
                return json(['code'=>400, 'msg'=>'重新登录']);
            }
        }else{
            return json(['code'=>400, 'msg'=>'重新登录']);
        }
    }


    //确认收货
    public function orderConfirm(){
    	if($this->check_token()){
            $openid = input('openid'); 
            $uid = $this->getUserId($openid);
            $id = input('id');
            if($uid){
            	db('order')->where('id',$id)->setField('order_status',3);
                return json(['code'=>200, 'msg'=>'确认收货成功']);

            }else{
                return json(['code'=>400, 'msg'=>'重新登录']);
            }
        }else{
            return json(['code'=>400, 'msg'=>'重新登录']);
        }
    }








    //////////////////////////微信支付所需方法/////////////////////

    // 获取指定长度的随机字符串
    public function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i ++) {
            $str .= $strPol[rand(0, $max)]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    // 获取当前服务器的IP
    public function get_client_ip(){
        if ($_SERVER['REMOTE_ADDR']) {
            $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv("REMOTE_ADDR")) {
            $cip = getenv("REMOTE_ADDR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $cip = getenv("HTTP_CLIENT_IP");
        } else {
            $cip = "unknown";
        }
        return $cip;
    }

    //生成签名
    public function sign($Obj){
        foreach ($Obj as $k => $v) {
            $Parameters[strtolower($k)] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . config('WXPAY.KEY');
        // 签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }

        //生成签名
    public function getSign($Obj){
        foreach ($Obj as $k => $v) {
            $Parameters[strtolower($k)] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String  = "appId=".$Obj['appId']."&nonceStr=".$Obj['nonceStr']."&package=".$Obj['package']."&signType=MD5&timeStamp=".$Obj['timeStamp'];
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . config('WXPAY.KEY');
        // 签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }

    // 数组转xml
    public function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }

    // post https请求，CURLOPT_POSTFIELDS xml格式
    public function postXmlCurl($xml, $url, $second = 30){
        // 初始化curl
        $ch = curl_init();
        // 超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        // 这里设置代理，如果有的话
        // curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        // curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        // 运行curl
        $data = curl_exec($ch);

        // 返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
                echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
                    curl_close($ch);
                    return false;
        }
    }

    // xml转成数组
    public function xmlstr_to_array($xmlstr){
        //禁止引用外部xml实体

        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xmlstr, 'SimpleXMLElement', LIBXML_NOCDATA);

        $val = json_decode(json_encode($xmlstring),true);

        return $val;


    }

    // 将数组转成uri字符串
    public function formatBizQueryParaMap($paraMap, $urlencode){
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= strtolower($k) . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

}
