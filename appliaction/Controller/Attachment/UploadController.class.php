<?php
vendor(autoload);
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UploadController extends BaseController
{
    public function _initialize() {
        parent::_initialize();
    }
    
    /**
     * 附件上传
     */
    public function upload() {
    }
    
    public function swfupload() {
        if(IMG_INTREFACE == 1){
            $file_keyarr = array_keys($_FILES);
            $file_key = $file_keyarr[0];
            $allowExts = array('jpg', 'gif', 'png', 'jpeg' , 'bmp' ,'pdf', 'doc' , 'docx' , 'mp4', 'avi', 'rmvb', 'wma' , '3gp');
            $file_path = $_FILES[$file_key]['tmp_name'];
            $file_name = $_FILES[$file_key]['name'];
            $extensionarr = explode('.', $file_name);
            $extension = $extensionarr[count($extensionarr)-1];
            if ($_FILES[$file_key]['error']==0 && in_array($extension, $allowExts)) {
                $accessKey = 'ReSn9Nm1VRyjuS669T1kxcUFje7acVjMW9DklDd9';
                $secretKey = 'pXtptDhCz3u7F10sB408fLDBpO5KOiQw9DFuL-LQ';
                // 构建鉴权对象
                $auth = new Auth($accessKey, $secretKey);
                // 要上传的空间
                $bucket = QINIU_UPLOAD_BUCKET;
                // 生成上传 Token
                $token = $auth->uploadToken($bucket);
                // 要上传文件的本地路径
                $filePath = $file_path;
                // 上传到七牛后保存的文件名
                $key = time().rand(100000,999999);
                // 初始化 UploadManager 对象并进行文件的上传
                $uploadMgr = new UploadManager();
                // 调用 UploadManager 的 putFile 方法进行文件的上传
                list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
                //var_dump($ret);
                if ($err !== null) {
                    $this->ajaxReturn(array('error' => 1, 'message' => '上传到七牛错误'));
                    exit();
                } else {
                    $this->ajaxReturn(array('error' => 0, 'url' =>$ret['key'] ));
                    exit();
                }
            }else{
                $this->ajaxReturn(array('error' => 1, 'message' => '上传到缓存错误'));
                exit();
            }

        }
        libfile('upload');
        $config = array("pathFormat" => 'uploads/uploadfile/image/{yyyy}{mm}{dd}/{time}{rand:6}',"maxSize" => 2048000,"allowFiles" => array(".png", ".jpg", ".jpeg", ".gif", ".bmp"));
        $fieldName = 'upfile';
        $up = new upload($fieldName, $config, $base64);
        $this->ajaxReturn($up->getFileInfo());
    }
    
    public function ueditor() {
        $base64 = "upload";
        libfile('upload');
        $ueditor_path = DOC_ROOT.  str_replace(__ROOT__, '', JS_PATH) . 'ueditor/';
        $config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents( $ueditor_path . "config.json")), TRUE);
        if($_GET['action'] == 'config') {
            $this->ajaxReturn($config);
        } elseif($_GET['action'] == 'catchimage') {
            $fileConfig = array(
                "pathFormat" => $config['catcherPathFormat'],
                "maxSize" => $config['catcherMaxSize'],
                "allowFiles" => $config['catcherAllowFiles'],
                "oriName" => "remote.png"
            );
            $fieldName = $config['catcherFieldName'];
            $lists = array();
            foreach ($_GET[$fieldName] as $imgUrl) {
                $item = new upload($imgUrl, $fileConfig, "remote");
                $info = $item->getFileInfo();
                array_push($lists, array(
                    "state" => $info["state"],
                    "url" => $info["url"],
                    "source" => $imgUrl
                ));
            }
            $result = array();
            $result['list'] = $lists;
            $result['state'] = (count($lists)) ? 'SUCCESS' : 'ERROR';
            $this->ajaxReturn($result);
        } else { 
            switch ($_GET['action']) {
                /* 上传图片 */
                case 'uploadimage':
                    $fileConfig = array(
                        "pathFormat" => $config['imagePathFormat'],
                        "maxSize" => $config['imageMaxSize'],
                        "allowFiles" => $config['imageAllowFiles']
                    );
                    $fieldName = $config['imageFieldName'];
                    break;
                /* 上传涂鸦 */
                case 'uploadscrawl':
                    $fileConfig = array(
                        "pathFormat" => $config['scrawlPathFormat'],
                        "maxSize" => $config['scrawlMaxSize'],
                        "allowFiles" => $config['scrawlAllowFiles'],
                        "oriName" => "scrawl.png"
                    );
                    $fieldName = $config['scrawlFieldName'];
                    $base64 = "base64";
                    break;
                /* 上传视频 */
                case 'uploadvideo':
                    $fileConfig = array(
                        "pathFormat" => $config['videoPathFormat'],
                        "maxSize" => $config['videoMaxSize'],
                        "allowFiles" => $config['videoAllowFiles']
                    );
                    $fieldName = $config['videoFieldName'];
                    break;
                case 'listimage':
                case 'listfile':
                    if($_GET['action'] == 'listfile') {
                        $allowFiles = $config['fileManagerAllowFiles'];
                        $listSize = $config['fileManagerListSize'];
                        $path = $config['fileManagerListPath'];
                    } else {
                        $allowFiles = $config['imageManagerAllowFiles'];
                        $listSize = $config['imageManagerListSize'];
                        $path = $config['imageManagerListPath'];
                    }
                    $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);
                    $size = isset($_GET['size']) ? $_GET['size'] : $listSize;
                    $start = isset($_GET['start']) ? $_GET['start'] : 0;
                    $end = $start + $size;
                    
                    $path = DOC_ROOT.(substr($path, 0, 1) == "/" ? "":"/") . $path;
                    $files = $this->getfiles($path, $allowFiles);
                    if (!count($files)) {
                        return json_encode(array(
                            "state" => "no match file",
                            "list" => array(),
                            "start" => $start,
                            "total" => count($files)
                        ));
                    }
                    $len = count($files);
                    for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
                        $list[] = $files[$i];
                    }
                    $result = array(
                        "state" => "SUCCESS",
                        "list" => $list,
                        "start" => $start,
                        "total" => count($files)
                    );
                    $this->ajaxReturn($result);
                    break;
                default:
                    $fileConfig = array(
                        "pathFormat" => $config['filePathFormat'],
                        "maxSize" => $config['fileMaxSize'],
                        "allowFiles" => $config['fileAllowFiles']
                    );
                    $fieldName = $config['fileFieldName'];
                    break;
            }
            $up = new upload($fieldName, $fileConfig, $base64);
            $this->ajaxReturn($up->getFileInfo());
        }
    }

    private function getfiles($path, $allowFiles, &$files = array())
        {
            if (!is_dir($path)) return null;
            if(substr($path, strlen($path) - 1) != '/') $path .= '/';
            $handle = opendir($path);
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $path2 = $path . $file;
                    if (is_dir($path2)) {
                        $this->getfiles($path2, $allowFiles, $files);
                    } else {
                        if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
                            $files[] = array(
                                'url'=> str_replace(DOC_ROOT, __ROOT__, $path2),
                                'mtime'=> filemtime($path2)
                            );
                        }
                    }
                }
            }
            return $files;
        }
}
