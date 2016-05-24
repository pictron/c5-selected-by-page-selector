<?php  defined('C5_EXECUTE') or die("Access Denied.");
	$c = Page::getCurrentPage();
	$nh = Loader::helper('navigation');
	
	if($pages):
	?>
<div class="review-list"><?php if($formname){ ?><h3><?php echo h($formname); ?></h3><?php } ?>
		<ul>
  		<?php
  		foreach ($pages as $p):
    	$href = $nh->getLinkToCollection($p);
    	?>
    	<li><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><a href="<?php echo h($href); ?>"><?php echo h($p->getCollectionName()); ?></a></li>
    	<?php
	    endforeach;
	    ?>
		</ul>
	</div>
	<?php if ($showPagination): ?>
    <?php echo $pagination;?>
  <?php endif; ?>
  <?php endif; ?>
