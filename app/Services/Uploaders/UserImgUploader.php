<?php
    namespace App\Services\Uploaders;

    class UserImgUploader extends ImgUploader{

        protected function getDir()
        {
            return 'users';
        }
    }
?>