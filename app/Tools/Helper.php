<?php
namespace App\Tools;

use App\Services\BaiLianService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Config\Annotation\Value;
use PhpCsFixer\ConfigInterface;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Spatie\PdfToText\Pdf;
use function Hyperf\Support\make;

class Helper
{
    #[Value("app_domain")]
    private $app_domain;

    #[Value("app_env")]
    private $env;




    public  static function buildTree(array $elements,string $keyField,string $parentField,$sort_field = "", $parentId = 0): array {
        $branch = [];
        foreach ($elements as $element) {
            if (!isset($element[$parentField])) $element[$parentField] = 0;
            if ($element[$parentField] == $parentId) {
                $children = self::buildTree($elements,$keyField,$parentField ,$sort_field,$element[$keyField]);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        if (!empty($branch) && isset($branch[0][$sort_field])) {
            usort($branch, function ($a, $b) use ($sort_field) {
                return $a[$sort_field] <=> $b[$sort_field]; // 升序排序
            });
        }
        return $branch;
    }


    public static function unsetArrayField(&$array,$fields = []) {
        foreach ($fields as $field) {
            unset($array[$field]);
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                self::unsetArrayField($array[$key], $fields);
            }
        }
    }

    public static function getUlid()
    {
        return Uuid::uuid7()->toString();

    }


    public static function getUrlFielExt($url)
    {
        // 获取路径部分
        $path = parse_url($url, PHP_URL_PATH);

// 提取文件扩展名
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        return strtolower($ext);

    }


    public  static function downloadFile(string $url, string $savePath): bool
    {
        $client = new Client([
            'timeout' => 60,
            'verify' => false, // 关闭SSL证书验证（有需要可以改成true）
        ]);

        try {
            $response = $client->request('GET', $url, [
                'sink' => $savePath, // 把响应直接写到文件
                'allow_redirects' => true, // 支持重定向
            ]);

            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            throw new RuntimeException('下载失败: ' . $e->getMessage());
        }
    }


    public static function getRuntimePath()
    {
        return dirname(__DIR__).'/../runtime';

    }



}