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
	public static function groupByInitials(array $data, string $targetKey = 'name'): array
    {
		$Pinyin = self::getPinyinList();
		$data = array_map(function ($item) use ($targetKey,$Pinyin) {
			return array_merge($item, [
				'initials' => self::getInitials($item[$targetKey],$Pinyin),
			]);
		}, $data);
        return self::sortInitials($data);
	}

	/**
	 * 按字母排序
	 * @param array $data
	 * @return array
	 */
	public static function sortInitials(array $data): array
    {
		$sortData = [];
		foreach ($data as $value) {
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
    public static function getInitials($str,$pinyins)
    {
        $str = trim($str);
        $first_str= mb_convert_encoding($str,"UTF-8","GB2312");//转码
        $fchar = ord($first_str{0});
        if ($fchar >= ord("A") and $fchar <= ord("z")) return strtoupper($first_str{0});//英文首字母快键处理
        $str = self::unicode_encode($str);
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
	public static function getPinyinList(): array
    {
        $Pinyin = [];
		$fp = fopen(dirname(__FILE__).'/pinyin.txt','r');
		while(!feof($fp))
		{
			$line = trim(fgets($fp));
			$rule = '/U\+(.*?): ([a-z])/';
			preg_match($rule,$line,$result);
            $Pinyin[$result[1]] = strtoupper($result[2]);
		}
		fclose($fp);
		return $Pinyin;
	}

	/**
	 * Unicode编码
	 * @param string $str 字符串
     * @return array 汉字数组
	 */
	private static function unicode_encode(string $str): array
    {
        $str = iconv('UTF-8', 'UCS-2', $str);
		$arrStr = str_split($str, 2);
		$unicodeStr = [];
		for($i = 0, $len = count($arrStr); $i < $len; $i++) {
			$dec = bin2hex($arrStr[$i]);
            $unicodeStr[] = '' . $dec . '';
		}
		return $unicodeStr;
	}


}