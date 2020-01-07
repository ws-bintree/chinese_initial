<?php

namespace chineseInitial;


/**
 * @author Bintree
 */
class getInitial
{
	/**
	 * 二维数组根据首字母分组排序
	 * @param array $data  二维数组
	 * @param string $targetKey 首字母的键名
	 * @return array    根据首字母关联的二维数组
	 */
	public function groupByInitials(array $data, $targetKey = 'name')
	{
		$pinyins = $this->getPinyinList();

		$data = array_map(function ($item) use ($targetKey,$pinyins) {
			return array_merge($item, [
				'initials' => $this->getInitials($item[$targetKey],$pinyins),
			]);
		}, $data);
		$data = $this->sortInitials($data);
		return $data;
	}

	/**
	 * 按字母排序
	 * @param array $data
	 * @return array
	 */
	public function sortInitials(array $data)
	{
		$sortData = [];
		foreach ($data as $key => $value) {
			$sortData[$value['initials']][] = $value;
		}
		ksort($sortData);
		return $sortData;
	}

	/**
	 * 获取首字母
	 * @param string $str 汉字字符串
	 * @return string 首字母
	 */
	public function getInitials($str,$pinyins)
	{
		$str = trim($str);

		$first_str= mb_convert_encoding($str,"UTF-8","GB2312");//转码

		$fchar = ord($first_str{0});
		if ($fchar >= ord("A") and $fchar <= ord("z")) return strtoupper($first_str{0});//英文首字母快键处理
		$str = $this->unicode_encode($str);

		$str = strtoupper($str[0]);
		if(isset($pinyins[$str])){
			return $pinyins[$str];
		}else{
			return '#';
		}
	}

	/**
	 * 获取拼音数组(可存缓存)
	 * @return array 汉字数组
	 */
	public function getPinyinList()
	{
		$fp = fopen(dirname(__FILE__).'/pinyin.txt','r');
		while(!feof($fp))
		{
			$line = trim(fgets($fp));
			$zhengze = '/U\+(.*?): ([a-z]{1})/';
			preg_match($zhengze,$line,$result);
			$pinyins[$result[1]] = strtoupper($result[2]);
		}
		fclose($fp);
		return $pinyins;
	}

	/**
	 * Unicode编码
	 * @param string $str 字符串
	 * @param string $encoding 编码类型
	 * @param string $prefix 前缀
	 * @param string $postfix 后缀
	 * @return array 汉字数组
	 */
	private function unicode_encode($str, $encoding = 'UTF-8', $prefix = '', $postfix = '') {
		$str = iconv($encoding, 'UCS-2', $str);
		$arrstr = str_split($str, 2);
		$unistr = [];
		for($i = 0, $len = count($arrstr); $i < $len; $i++) {
			$dec = bin2hex($arrstr[$i]);
			$unistr[] = $prefix . $dec . $postfix;
		}
		return $unistr;
	}


}