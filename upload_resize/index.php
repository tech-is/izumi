<?php
function uploadImage($tmpName, $dir, $maxWidth, $maxHeight)
{

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmpName);

    if ($mime == 'image/jpeg' || $mime == 'image/pjpeg') {
        $ext = '.jpg';
        $image1 = imagecreatefromjpeg($tmpName);
    } elseif ($mime == 'image/png' || $mime == 'image/x-png') {
        $ext = '.png';
        $image1 = imagecreatefrompng($tmpName);
    } elseif ($mime == 'image/gif') {
        $ext = '.gif';
        $image1 = imagecreatefromgif($tmpName);
    } else {
        return false;
    }

    list($width1, $height1) = getimagesize($tmpName);

    if ($width1 <= $maxWidth && $height1 <= $maxHeight) {
        $scale = 1.5;   //サイズ小さい、倍率
    } else {
        $scale = min($maxWidth / $width1, $maxHeight / $height1);   //サイズ大きい
    }

    $width2 = $width1 * $scale;
    $height2 = $height1 * $scale;

    $image2 = imagecreatetruecolor($width2, $height2);

    if ($ext == '.gif') {
        $transparent1 = imagecolortransparent($image1);
        if ($transparent1 >= 0) {
            $index = imagecolorsforindex($image1, $transparent1);
            $transparent2 = imagecolorallocate($image2, $index['red'], $index['green'], $index['blue']);
            imagefill($image2, 0, 0, $transparent2);
            imagecolortransparent($image2, $transparent2);
        }
    } elseif ($ext == '.png') {
        imagealphablending($image2, false);
        $transparent = imagecolorallocatealpha($image2, 0, 0, 0, 127);
        imagefill($image2, 0, 0, $transparent);
        imagesavealpha($image2, true);
    }

    imagecopyresampled($image2, $image1, 0, 0, 0, 0, $width2, $height2, $width1, $height1);

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $filename = sha1(microtime() . $_SERVER['REMOTE_ADDR'] . $tmpName) . $ext;
    $saveTo = rtrim($dir, '/\\') . '/' . $filename;

    if ($ext == '.jpg') {
        $quality = 80;
        imagejpeg($image2, $saveTo, $quality);
    } else if ($ext == '.png') {
        imagepng($image2, $saveTo);
    } else if ($ext == '.gif') {
        imagegif($image2, $saveTo);
    }

    imagedestroy($image1);
    imagedestroy($image2);

    return $saveTo;
}

if (
    $_SERVER["REQUEST_METHOD"] === 'POST'
    && !empty($_FILES['image']['tmp_name'])
) {
    $now = new DateTime();

    $maxWidth = 150;    // 最大幅
    $maxHeight = 150;   // 最大高さ

    // 一時ファイルの場所
    $tmpName = $_FILES['image']['tmp_name'];

    // 保存先のディレクトリ
    $dir = __DIR__ . '/uploads/';
    $path = uploadImage($tmpName, $dir, $maxWidth, $maxHeight);
    var_dump($path);
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>image</title>
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" value="submit">
    </form>
</body>

</html>