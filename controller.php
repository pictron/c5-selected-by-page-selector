<?php
namespace Application\Block\SelectedByPageSelector;

use Core;
use CollectionAttributeKey;
use File;
use Database;
use Page;
use PageList;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Attribute\Key\CollectionKey;

class Controller extends BlockController
{
    protected $btInterfaceWidth = 300;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btInterfaceHeight = 320;
    protected $btTable = 'SelectedByPageSelector';

    protected $btExportFileColumns = array('fID');
    
    public function __construct($b = null){
    parent::__construct($b);
    
    $db = Database::connection();
    $query = $db->createQueryBuilder();
    $query->select('*')->from('AttributeTypes')->where('atHandle = :ps')->setParameter('ps', 'page_selector');
    $r = $query->Execute();
    $row = $r->fetchRow();
    
    $attquery = $db->createQueryBuilder();
    $attquery->select('*')->from('AttributeKeys')->where('atID = :pageselectorID')->setParameter('pageselectorID', $row['atID']);
    $attlist = $attquery->Execute();
    $anserlist = array();
    while ($row = $attlist->fetchRow()) {
        $anserlist[$row['akID']] = $row['akName'];
    }
    $this->set('anserlist',$anserlist);
    $this->set('num',$this->num);
    }


    /** 
     * Used for localization. If we want to localize the name/description we have to include this.
     */
    public function getBlockTypeDescription()
    {
        return t("Page List of Selected By Page Selector");
    }

    public function getBlockTypeName()
    {
        return t("Selected By Page Selector");
    }

    public function getJavaScriptStrings()
    {
        return array('file-required' => t('You must select attribute.'));
    }

    public function validate($args)
    {
        $e = Core::make('helper/validation/error');
        if (trim($args['akID']) == '') {
            $e->add(t('You must give your attribute.'));
        }

        return $e;
    }
    public function view(){
      $db = Database::connection();
      $query = $db->createQueryBuilder();
      $query->select('akID')->from('SelectedByPageSelector')->where('bID = :thisblock')->setParameter('thisblock',$this->bID);
      $r = $query->Execute();
      $row = $r->fetchRow();
      
      $attquery = $db->createQueryBuilder();
      $attquery->select('*')->from('AttributeKeys')->where('akID = :attID')->setParameter('attID', $row['akID']);
      $attlist = $attquery->Execute();
      $attkey = $attlist->fetchRow();
      
      $c = Page::getCurrentPage();
      if (is_object($c)) {
          $this->cID = $c->getCollectionID();
      }
      $list = new \Concrete\Core\Page\PageList();
      $list->filterByAttribute($attkey["akHandle"],$this->cID);
      
      switch ($this->orderBy) {
          case 'display_asc':
              $list->sortByDisplayOrder();
              break;
          case 'display_desc':
              $list->sortByDisplayOrderDescending();
              break;
          case 'chrono_asc':
              $list->sortByPublicDate();
              break;
          case 'random':
              $list->sortBy('RAND()');
              break;
          case 'alpha_asc':
              $list->sortByName();
              break;
          case 'alpha_desc':
              $list->sortByNameDescending();
              break;
          default:
              $list->sortByPublicDateDescending();
              break;
      }
    	/*$pages = $list->getResults();
    	$this->set('pages',$pages);*/
    	//Pagination...
      $showPagination = false;
      if ($this->num > 0) {
          $list->setItemsPerPage($this->num);
          $pagination = $list->getPagination();
          $pages = $pagination->getCurrentPageResults();
          if ($pagination->getTotalPages() > 1 && $this->paginate) {
              $showPagination = true;
              $pagination = $pagination->renderDefaultView();
              $this->set('pagination', $pagination);
          }
      } else {
          $pages = $list->getResults();
      }

      if ($showPagination) {
          $this->requireAsset('css', 'core/frontend/pagination');
      }
      $this->set('pages', $pages);
      $this->set('list', $list);
      $this->set('showPagination', $showPagination);

    }
}
