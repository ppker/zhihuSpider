<?php
/**
 * @Author: huhuaquan
 * @Date:   2015-08-10 18:08:43
 * @Last Modified by:   huhuaquan
 * @Last Modified time: 2016-05-27 18:21:16
 */
require_once './function.php';
class Curl {

	private static $cookie_arr = array(
		'__utma' => '51854390.213673896.1474875878.1474875878.1474875878.1',
		'__utmb' => '51854390.26.10.1474875878',
		'__utmc' => '51854390',
		'__utmt' => '1',
		'__utmv' => '51854390.100--|2=registration_date=20160913=1^3=entry_date=20160913=1',
		'__utmz' => '51854390.1474875878.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)',
		'_xsrf' => '5a824704e243f6a1d04281da10beaa30',
		'_za' => '2721444d-4c33-4089-ac1e-4943955d8762',
		'_zap' => '06509698-1385-4342-838a-e021575927ce',
		'a_t' => '"2.0AGAAAxdqiAoXAAAAIWEQWABgAAMXaogKAFDAXKVwmQoXAAAAYQJVTfVeEFgA54mTO_p4lASC6vpuD7mn5klhE1o0ZqNam0EccxFdmRjZRaLnYCOmdQ=="',
		'cap_id' => '"ZGUyNDU4MzU5YzY0NDk1NWJjY2VhMWFmYzhkZjFkMWE=|1474875876|087469976b8e87bcdc73d962afa41b3165dc3a03"',
		'd_c0' => '"AFDAXKVwmQqPToxbUuOVh6HHbCCY4gV5ECg=|1474875877"',
		'l_cap_id' => '"YmQ3MzhkZTY5MTM4NGNlNDgwMzliY2EyMTA1NTMxMWY=|1474875876|a83a09f157b04f2ed595c17cd07bb3492e38efdf"',
		'login' => '"NWEwYWVjY2MwODE3NDQwNmE4M2VlZDA5MzRlZGQ1OTg=|1474875893|7626f70d868501b97d73baf09b03b599f0b81f72"',
		'n_c' => '1',
		'q_c1' => '7a586da7161846458283ae7a7ac0b535|1474875877000|1474875877000',
		'z_c0' => 'Mi4wQUdBQUF4ZHFpQW9BVU1CY3BYQ1pDaGNBQUFCaEFsVk45VjRRV0FEbmlaTTctbmlVQklMcS1tNFB1YWZtU1dFVFdn|1474876449|fb2de7fa429509c0277c6ee15d4f58c8e062c49a',
	);

	private static function genCookie() {
		$cookie = '';
		foreach (self::$cookie_arr as $key => $value) {
			if($key != 'z_c0')
				$cookie .= $key . '=' . $value . ';';
			else
				$cookie .= $key . '=' . $value;
		}
		return $cookie;
	}

	/**
	 * [request 执行一次curl请求]
	 * @param  [string] $method     [请求方法]
	 * @param  [string] $url        [请求的URL]
	 * @param  array  $fields     [执行POST请求时的数据]
	 * @return [stirng]             [请求结果]
	 */
	public static function request($method, $url, $fields = array())
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_COOKIE, self::genCookie());  // Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.82 Safari/537.36
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.82 Safari/537.36');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		if ($method === 'POST')
		{
			curl_setopt($ch, CURLOPT_POST, true );
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		}
		$result = curl_exec($ch);
		$err = curl_error($ch);

		if (false === $result || !empty($err)) {
			$Errno = curl_errno($ch);
			$Info = curl_getinfo($ch);
			curl_close($ch);
			return array(
				'result' => false,
				'errno' => $Errno,
				'msg' => $err,
				'info' => $Info,
			);
		}

		return $result;
	}

	/**
	 * [getMultiUser 多进程获取用户数据]
	 * @param  [type] $user_list [description]
	 * @return [type]            [description]
	 */
	public static function getMultiUser($user_list)
	{
		$ch_arr = array();
		$text = array();
		$len = count($user_list);
		$max_size = ($len > 5) ? 5 : $len;
		$requestMap = array();

		$mh = curl_multi_init();
		for ($i = 0; $i < $max_size; $i++)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_URL, 'http://www.zhihu.com/people/' . $user_list[$i] . '/about');
			curl_setopt($ch, CURLOPT_COOKIE, self::genCookie());
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$requestMap[$i] = $ch;
			curl_multi_add_handle($mh, $ch);
		}

		$user_arr = array();
		do {
			while (($cme = curl_multi_exec($mh, $active)) == CURLM_CALL_MULTI_PERFORM);
			
			if ($cme != CURLM_OK) {break;}

			while ($done = curl_multi_info_read($mh))
			{
				$info = curl_getinfo($done['handle']);
				$tmp_result = curl_multi_getcontent($done['handle']);
				$error = curl_error($done['handle']);

				$user_arr[] = array_values(getUserInfo($tmp_result));

				//保证同时有$max_size个请求在处理
				if ($i < sizeof($user_list) && isset($user_list[$i]) && $i < count($user_list))
                {
                	$ch = curl_init();
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_URL, 'http://www.zhihu.com/people/' . $user_list[$i] . '/about');
					curl_setopt($ch, CURLOPT_COOKIE, self::$user_cookie);
					curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					$requestMap[$i] = $ch;
					curl_multi_add_handle($mh, $ch);

                    $i++;
                }

                curl_multi_remove_handle($mh, $done['handle']);
			}

			if ($active)
                curl_multi_select($mh, 10);
		} while ($active);

		curl_multi_close($mh);
		return $user_arr;
	}

}