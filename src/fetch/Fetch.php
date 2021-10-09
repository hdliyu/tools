<?php
namespace Hdliyu\Tools\fetch;

class Fetch{
    protected $path='./img/products/*';

    protected $html = <<<html
    <!-- #%s START 【%s】 -->
    <div class="flexW">
    <div class="imgW">
        <div class="proSlick">
            %s
        </div>
    </div>
    <div class="textW">
        <h3 class="pubTit">%s</h3>
        <div class="des">
            %s
        </div>
        <a href="javascript:;" class="pubBtn popform2">inquiry</a>
    </div>
    </div>
    <!-- #%s END 【%s】 -->
    
html;

    protected $img = <<<img
    <div class="item">
    <img src="%s" alt="">
    </div>

img;

    public function path($path){
      $this->path = rtrim($path,'/').'/*';
      return $this;
    }

    public function base($baseTemplate){
        $this->html = $baseTemplate;
        return $this;
    }

    public function item($itemTemplate){
        $this->img = $itemTemplate;
        return $this;
    }

    public function config($path,$baseTemplate,$itemTemplate){
        $this->path = $path;
        $this->html = $baseTemplate;
        $this->img = $itemTemplate;
        return $this;
    }

    protected function make($action='docx2html',$preview=false){
        $all = '';
        foreach (glob($this->path,GLOB_ONLYDIR) as $k=>$dir) {
            $imgs = '';
            $desc = '';
            $basename = basename($dir);
            foreach (glob($dir.'/[!~$]*') as $file) {
                $ext = strtolower(pathinfo($file)['extension']);
                if(in_array($ext,['jpg','jpeg','png'])){//产品图片
                    $imgs.=sprintf($this->img,$preview?$file:$this->getFilePath($file));
                }elseif($ext=='docx'){//产品描述
                    $desc = $this->$action($file);
                }elseif($ext=='txt'){
                    $desc = file_get_contents($file);
                }
            }
            $all.=sprintf($this->html,$k+1,$basename,$imgs,$basename,$desc,$k+1,$basename);
        }
        return $all;
    }

    public function makeHtml(){
        return nl2br(htmlspecialchars($this->make('docx2html')));
    }

    public function makeText(){
        return $this->make('docx2text');
    }

    public function makePreview(){
        return $this->make('docx2html',true);
    }
    
    private function docx2html($docx){
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($docx);
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, "HTML");
        $content = '';
        foreach ($phpWord->getSections() as $section) {
            $writer = new \PhpOffice\PhpWord\Writer\HTML\Element\Container($htmlWriter, $section);
            $content .= $writer->write();
        }
        return $content;
     }
    
    
    private function docx2text($docx){
         return strip_tags($this->docx2html($docx));
     }

     private function getFilePath($file){
       $names = explode('/',$file);
       array_shift($names);array_shift($names);
       return implode('/',$names);
     }
}

