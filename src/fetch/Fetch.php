<?php
namespace Hdliyu\Tools\fetch;

class Fetch{
    protected $path='./img/products/*';

    protected $html = <<<html
    <!-- %s -->
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
html;

    protected $img = <<<img
    <div class="item">
    <img src="%s" alt="">
    </div>

img;

    public function path($path){
      $this->path = $path;
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

    protected function make($action='docx2html'){
        $all = '';
        foreach (glob($this->path,GLOB_ONLYDIR) as $k=>$dir) {
            $imgs = '';
            $desc = '';
            foreach (glob($dir.'/[!~$]*') as $file) {
                $ext = strtolower(pathinfo($file)['extension']);
                if(in_array($ext,['jpg','jpeg','png'])){//产品图片
                    $imgs.=sprintf($this->img,substr($file,2));
                }elseif($ext=='docx'){//产品描述
                    $desc = $this->$action($file);
                }elseif($ext=='txt'){
                    $desc = file_get_contents($file);
                }
            }
            $all.=sprintf($this->html,$k+1,$imgs,basename($dir),$desc);
        }
        return $all;
    }

    public function makeHtml(){
        return nl2br(htmlspecialchars($this->make('docx2html')));
    }

    public function makeText(){
        return $this->make('docx2text');
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
    
     function docx2text($docx){
         return strip_tags($this->docx2html($docx));
     }


}

