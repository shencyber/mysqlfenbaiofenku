<?php

namespace app\index\controller;
Use think\Controller;
Use \think\Request;
Use think\Db;

class Uuid extends Controller
{
	/**
     * 初始化方法,可以控制用户权限、获取菜单等等，只要是继承base类的其它业务类就不需要再重写
     */
    public  function addUser()
    {
    	$phone = "114@qq.com";
        $userTableId = $this->hashId( $phone , 3 );
        $res = Db::table("user".$userTableId)->insert([ 'phone' => $phone ]);
        dump( $res );
 
    }

    public function getPhone()
    {
    	$phone = "114@qq.com";
        $userTableId = $this->hashId( $phone , 3 );
        $res = Db::table("user".$userTableId)->where('phone',$phone)->select();
        dump( $res );
    }

    function addUserLoop()
    {
    	$data = Array();
    	for( $i=0;$i<100000;$i++  )
    	{
    		array_push( $data , ['phone'=>1]  );
    	}

        $res = Db::table("user")->insertAll( $data );
        unset($data);
    }

 //    function getStringHash($string, $tab_count)
	// {
	//         $unsign = sprintf('%u', crc32($string));
	//         if ($unsign > 2147483647)  // sprintf u for 64 & 32 bit
	//         {
	//             $unsign -= 4294967296;
	//         }
	//         return abs($unsign) % $tab_count;
	// }

    //分局用户登录账号获取hashid
	function hashId( $id, $tab_count )
	{
		$md5 = md5($id);
	    $str1 = substr($md5, 0, 2);
	    $str2 = substr($md5, -2, 2);
	    $newStr = intval(intval($str1 . $str2, 16));
	    $hashID = $newStr % $tab_count ;
	    return $hashID;
	}

}


?>