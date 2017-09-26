<?php

/**
 * ajax分页widget
 * -----------------------------------
 * $this->widget('widgets.pages.ListPagesDWidget', array('pages' => $pages,)) 
 * -----------------------------------
 */
class ListPagesDWidget extends CBasePager {

    public $params; //主控制器参数
    public $maxButtonCount; //最大按钮数
    public $isAjax = true; //判断是否为ajax分页 不是ajax则页面刷新分页

    public function run() {
        $this->maxButtonCount = !empty($this->maxButtonCount) ? $this->maxButtonCount : 5;
        $TotalPage = $this->getPageCount(); //总页数
        $CurrentPage = $this->getCurrentPage() + 1; //当前页
        $TotalRecord = $this->getItemCount(); //总记录数
        if ($TotalPage <= 1)
            return;
        $pPage = ($CurrentPage - 1 > 0) ? $CurrentPage - 1 : 0;
        $nPage = ($CurrentPage + 1 > $TotalPage) ? $TotalPage : $CurrentPage + 1;
        if ($TotalPage > $this->maxButtonCount) {
            $total = $this->maxButtonCount;
        } else {
            $total = $TotalPage;
        }
        $str = '';
        if ($CurrentPage == 1) {
            //	$str.='<li class="active"><a>«</a></li>';
        } else {
            //	$str.='<li>'.CHtml::link('首页',$this->createPageUrl(0),array('data-page'=>1)).'</li>';
        }
        if ($CurrentPage > 1) {
            //上一页
            $str.='<li>' . CHtml::link('«', $this->createPageUrl($pPage - 1), array('data-page' => $pPage, 'class' => 'p_left')) . '</li>';
        }
        //中间页
        $a = floor($this->maxButtonCount / 2);
        if ($CurrentPage - $a < 1 || $CurrentPage + $a > $TotalPage) {
            for ($i = 1; $i <= $total; $i++) {
                $o = $CurrentPage % $total;
                $u = $CurrentPage - $o + $i;
                if ($CurrentPage == $u && $TotalPage - $CurrentPage >= $this->maxButtonCount) {
                    $str.='<li class="active"><a>' . $u . '</a></li>';
                } else {
                    if ($TotalPage - $CurrentPage < $this->maxButtonCount) {
                        $differ = ($TotalPage - $this->maxButtonCount) < 0 ? 0 : $TotalPage - $this->maxButtonCount;
                        for ($s = $differ + 1; $s <= $TotalPage; $s++) {
                            if ($CurrentPage == $s) {
                                $str.='<li class="active"><a>' . $s . '</a></li>';
                            } else {
                                $str.='<li>' . CHtml::link($s, $this->createPageUrl($s - 1), array('data-page' => $s)) . '</li>';
                            }
                        }
                        break;
                    }
                    if ($u > $TotalPage)
                        break;
                    else {
                        $str.='<li>' . CHtml::link($u, $this->createPageUrl($u - 1), array('data-page' => $u)) . '</li>';
                    }
                }
            }
        } else {
            for ($i = $a; $i > 0; $i--) {
                $str.='<li>' . CHtml::link($CurrentPage - $i, $this->createPageUrl($CurrentPage - $i - 1), array('data-page' => $CurrentPage - $i)) . '</li>';
            }
            $str.='<li class="active"><a>' . $CurrentPage . '</a></li>';
            for ($i = 0; $i < $a; $i++) {
                $str.='<li>' . CHtml::link($CurrentPage + $i + 1, $this->createPageUrl($CurrentPage + $i), array('data-page' => $CurrentPage + $i + 1)) . '</li>';
            }
        }
        if ($CurrentPage < $TotalPage) {
            //下一页
            $str.='<li>' . Chtml::link('»', $this->createPageUrl($nPage - 1), array('data-page' => $nPage, 'class' => 'p_right')) . '</li>';
        }
        if ($CurrentPage == $TotalPage) {
            //$str.='<li class="active"><a >尾页</a></li>';
        } else {
            //$str.='<li>'.CHtml::link('尾页',$this->createPageUrl($TotalPage-1),array('data-page'=>$TotalPage)).'</li>';
        }


        echo $str;
    }

}
?> 
