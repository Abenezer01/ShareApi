<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Response;
use Image;
class ImageService extends Controller
{
    protected $noImage="noImage.png";
    public function itemGroupImage($imageName="noImage.png"){
        $path = config('global.picturePaths.menuItemsGroup');
        return $this->getImage($path,$imageName);
      }
      public function avatar($imageName="noImage.png"){
        $path = config('global.picturePaths.avatar');
        return $this->getImage($path,$imageName);
      }
      public function menuItemImage($imageName="noImage.png"){
        $path = config('global.picturePaths.menuItem');
        return $this->getImage($path,$imageName);
      }
      public function sPCatagory($imageName="noImage.png"){
        $path = config('global.picturePaths.serviceCatagories');
        return $this->getImage($path,$imageName);
      }
      public function sPLogo($imageName="noImage.png"){
        $path = config('global.picturePaths.CHRLServiceProvider');
        return $this->getImage($path,$imageName);
      }
      public function getImage($path,$imageName){
        $imageName=str_replace(' ', '%20',$imageName);
        $fullPath=$path.$imageName;
        if(!$this->does_url_exists($fullPath)){
            $fullPath=$path.$this->noImage;
        }
        $file = file_get_contents($fullPath);
        $type = get_headers($fullPath);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
      }

      function does_url_exists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
}
