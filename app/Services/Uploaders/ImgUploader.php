<?php
    namespace App\Services\Uploaders;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;

    abstract class ImgUploader{

        protected const ROOT = 'uploads';
        protected $request, $key, $uploaded_file_path;

        public function __construct(Request $request, string $key)
        {
            $this->request = $request;
            $this->key = $key;
        }

        static protected function getPathSperator()
        {
            return '/';
        }

        protected function getPath()
        {
            return  self::ROOT . self::getPathSperator() . $this->getDir();
        }

        protected function getUniqueName()
        {
            return date("Y-m-d") . '_' . time();
        }

        protected function getExtension()
        {
            return $this->request->file( $this->key )->getClientOriginalExtension();
        }

        protected function getNewNameWithExtension()
        {
            return $this->getUniqueName() . '.' . $this->getExtension();
        }

        static public function clean($path)
        {
            return Storage::delete($path);
        }

        public function isValid()
        {
            if ($this->request->has( $this->key )) {
                return true;
            }
            return false;
        }

        public function getuploadedPath()
        {
            return $this->uploaded_file_path ?? '';
        }

        protected function upload()
        {
            $this->uploaded_file_path = Storage::putFileAs( $this->getPath(), $this->request->file($this->key), $this->getNewNameWithExtension());
        }

        public function checkAndUpload()    :bool
        {
            if ($this->isValid())
            {
                $this->upload();
                return true;
            }
            
            return false;
        }
        
        // protected to force child class to specify its root dir ( forggetten not allowed here)
        abstract protected function getDir();

    }
?>