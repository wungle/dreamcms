<?php
/**

########################################### Common sample
App::uses("ImageResizer", 'Mobile.Lib');

$img = new ImageResizer();
$img->fromFile("/images/photo.jpg");
$img->width; // original width, or alternate use $img->getImageWidth();
$img->height; // original height, or alternate use $img->getImageHeight();

// Processing

$img->resizeTo($width, $height); // Force resize to specific size
$img->resizeToWidth($width); // Resize to width (Height proportional)
$img->resizeToHeight($height); // Resize to height (Width proportional)
$img->crop($x, $y, $width, $height); // Crop from specified position

$img->getImageWidth(); // Return image width after last processing
$img->getImageHeight(); // Return image height after last processing

// Output result

$img->saveFile("/images/photo_edited.jpg", IMAGETYPE_JPEG); // Save output as file type JPEG
$img->printJpegStream(); // Display output to browser

// Optional

$img->free(); // Free resource

########################################### Frame sample

App::uses("ImageResizer", 'Mobile.Lib');
$photo_sample = APP . "webroot/images/frame_template_sample.jpg";
$photo_frame = APP . "webroot/images/frame_template_2.png";
$img_frame = new ImageResizer($photo_frame);

$img_sample = new ImageResizer($photo_sample);
$img_sample->merge($img_frame->getImage());
$img_sample->resizeToWidth(100);

header("Content-Type: image/jpeg");
@imagejpeg($img_sample->getImage());
die();

**/

class ImageResizer {
    private $image;
    private $tmpImage;
    private $filename;
    public $width = 0;
    public $height = 0;

    // PHP IMAGETYPE_* CONSTANT (1=IMAGETYPE_GIF, 2=IMAGETYPE_JPEG, 3=IMAGETYPE_PNG)
    public $type = 0;

    // Quality range from 1-100
    private $quality = 70;

    function  __construct($filename = null) {
        if(is_string($filename)) {
            $this->fromFile($filename);
        }
    }

    public function fromFile($filename) {
        if(($image = getimagesize($filename)) === false)
            return false;

        $this->filename = $filename;
        $this->width = $image[0];
        $this->height = $image[1];
        $this->type = $image[2];

        $typemap = array(1 => "gif", 2 => "jpeg", 3 => "png");
        if(!isset($typemap[$this->type]))
            return false;

        $createFunction = "imagecreatefrom" . $typemap[$this->type];
        $this->image = $createFunction($filename);

        return true;
    }

    public function fromResource($image, $type) {
        if(!is_resource($image))
            return false;

        $this->width = imagesx($image);
        $this->height = imagesy($image);
        $this->type = $type;

        $this->image = $image;

        return true;
    }

    public function setBlendingMode($enabled = true) {
        imagealphablending($this->image, $enabled);
        return $this;
    }

    public function resizeTo($width, $height) {
        return $this->resize($width, $height);
    }

    public function resizeToHeight($height) {
        $toHeight = $height;
        $toWidth = round(($toHeight*$this->width) / $this->height);
        return $this->resize($toWidth, $toHeight);
    }

    public function resizeToWidth($width) {
        $toWidth = $width;
        $toHeight = round(($toWidth*$this->height) / $this->width);
        return $this->resize($toWidth, $toHeight);
    }

    public function resizeToProportional($size) {
        if($this->width > $this->height) {
            return $this->resizeToWidth($size);
        }
        elseif($this->height > $this->width) {
            return $this->resizeToHeight($size);
        }
        return $this->resizeTo($size, $size);
    }

    private function resize($toWidth, $toHeight) {
        $this->tmpImage = imagecreatetruecolor($toWidth, $toHeight);
        if($this->type == IMAGETYPE_PNG || $this->type == IMAGETYPE_GIF)
        {   // Preserve transparency
            imagealphablending($this->tmpImage, false);
            imagesavealpha($this->tmpImage, true);
        }
        imagecopyresampled($this->tmpImage, $this->image, 0, 0, 0, 0, $toWidth, $toHeight, $this->width, $this->height);

        return $this;
    }

    public function crop($x, $y, $width, $height) {
        $this->tmpImage = imagecreatetruecolor($width, $height);
        if($this->type == IMAGETYPE_PNG || $this->type == IMAGETYPE_GIF)
        {   // Preserve transparency
            imagealphablending($this->tmpImage, false);
            imagesavealpha($this->tmpImage, true);
        }
        $result = imagecopyresampled($this->tmpImage, $this->image, 0, 0, $x, $y, $width, $height, $width, $height);

        $this->width = $width;
        $this->height = $height;
        return $this;        
    }

    //
    // Merge 
    public function merge($image) {
        $this->tmpImage = imagecreatetruecolor($this->width, $this->height);
        imagealphablending($this->tmpImage, true);
        $transparent = imagecolorallocatealpha($this->tmpImage, 0, 0, 0, 127 );
        imagefill($this->tmpImage, 0, 0, $transparent); 
        
        imagecopyresampled($this->tmpImage, $this->image,0,0,0,0, $this->width, $this->height, $this->width, $this->height);
        imagecopyresampled($this->tmpImage, $image,0,0,0,0, $this->width, $this->height, $this->width, $this->height);
        imagealphablending($this->tmpImage, false); 
        imagesavealpha($this->tmpImage, true);
        
        $this->image = $this->tmpImage;
        return $this;
    }

    //
    // Add dropshadow effect to the resultImage
    public function dropshadow($background = "#FFFFFF", $offset = 3, $steps = 10, $spread = 1) {
        $background = $this->html2rgb($background);
        $o_width = imagesx($this->tmpImage);
        $o_height = imagesy($this->tmpImage);
        $width = $o_width + $offset;
        $height = $o_height + $offset;
        $canvas = imagecreatetruecolor($width, $height);
        $step_offset = array("r" => ($background["r"]/$steps), "g" => ($background["g"]/$steps), "b" => ($background["b"]/$steps));
        $current_color = $background;
        $colors = array();
        for ($i = 0; $i <= $steps; $i++)
        {
            $colors[$i] = imagecolorallocate($canvas, round($current_color["r"]), round($current_color["g"]), round($current_color["b"]));
            $current_color["r"] -= $step_offset["r"];
            $current_color["g"] -= $step_offset["g"];
            $current_color["b"] -= $step_offset["b"];
        }
        imagefilledrectangle($canvas, 0,0, $width, $height, $colors[0]);
        for ($i = 0; $i < count($colors); $i++)
        {
            imagefilledrectangle($canvas, $offset, $offset, $width, $height, $colors[$i]);
            $width -= $spread;
            $height -= $spread;
        }
        imagecopymerge($canvas, $this->tmpImage, 0,0, 0,0, $o_width, $o_height, 100);
        $this->tmpImage = $canvas;

        return $this;
    }

    //
    // HTML color representation to RGB
    public static function html2rgb($color) {
        if($color{0} == "#")
        {
            $color = substr($color, 1);
        }
        if (strlen($color) == 6)
        {
            list($r, $g, $b) = array($color{0}.$color{1}, $color{2}.$color{3}, $color{4}.$color{5});
        }
        elseif (strlen($color) == 3)
        {
            list($r, $g, $b) = array($color{0}.$color{0}, $color{1}.$color{1}, $color{2}.$color{2});
        }
        else
        {
            return array("r" => 255, "g" => 255, "b" => 255);
        }
        return array("r" => hexdec($r), "g" => hexdec($g), "b" => hexdec($b));
    }

    public function setQuality($quality) {
        $this->quality = $quality;
        return $this;
    }

    public function saveFile($targetFilename, $targetType = IMAGETYPE_JPEG) {
        if(!$targetType)
            $targetType = IMAGETYPE_JPEG;

        $typemap = array(1 => "gif", 2 => "jpeg", 3 => "png");
        if(!isset($typemap[$targetType]))
            return false;

        if($targetType == IMAGETYPE_JPEG)
        {
            @imagejpeg($this->tmpImage, $targetFilename, $this->quality);
        }
        elseif($targetType == IMAGETYPE_PNG)
        {
            $quality = floor($this->quality/10);
            @imagepng($this->tmpImage, $targetFilename, $quality);
        }
        else
        {
            $outputFunction = "image" . $typemap[$targetType];
            @$outputFunction($this->tmpImage, $targetFilename);
        }
        
        @chmod($targetFilename, 0666);
        return $this;
    }

    public function saveJpeg($targetFilename) {
        return $this->saveFile($targetFilename, IMAGETYPE_JPEG);
    }

    //
    // Get the current image resource
    public function getImage() {
        return $this->tmpImage ? $this->tmpImage : $this->image;
    }

    public function getImageWidth() {
        return imagesx($this->getImage());
    }

    public function getImageHeight() {
        return imagesy($this->getImage());
    }

    //
    // Print Jpeg stream and utilize the browser cache
    public function printJpegStreamCached() {
        $lastmodified = filemtime($this->filename);
        $etag = md5($lastmodified.$this->filename);
        $gmtime = gmdate("D, d M Y H:i:s", $lastmodified) . " GMT";

        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("ETag: \"$etag\"");
        if($_SERVER["HTTP_IF_MODIFIED_SINCE"] == $gmtime || str_replace("\"", "", stripslashes($_SERVER["HTTP_IF_NONE_MATCH"])) == $etag)
        {
            header("HTTP/1.1 304 Not Modified");
            return false;
        }
        header("Last-Modified: $gmtime");
        header("Content-Transfer-Encoding: binary");
        header("Content-Type: image/jpeg");
        @imagejpeg($this->getImage(), null, $this->quality);
        return true;
    }

    //
    // Print Jpeg stream
    public function printJpegStream() {
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Transfer-Encoding: binary");
        header("Content-Type: image/jpeg");
        @imagejpeg($this->getImage(), null, $this->quality);
    }
    
    //
    // Print Jpeg stream
    public function printPngStream() {
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Transfer-Encoding: binary");
        header("Content-Type: image/png");
        @imagepng($this->getImage());
    }
    

    //
    // Free some resource
    public function free() {
        if($this->tmpImage) {
            imagedestroy($this->tmpImage);
        }
    }

    //
    // Reset class to empty state
    public function reset() {
        if($this->image) {
            imagedestroy($this->image);
            if($this->tmpImage) {
                imagedestroy($this->tmpImage);
            }
            $this->filename = null;
            $this->width = 0;
            $this->height = 0;
            $this->type = 0;
            $this->quality = 70;
        }

        return $this;
    }
}