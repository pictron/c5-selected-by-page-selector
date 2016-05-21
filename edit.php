<?php
    defined('C5_EXECUTE') or die("Access Denied.");
?>
<div class="form-group">
	<?php echo $form->label('formname', t('Form Name'))?>
	<?php echo $form->text('formname', $controller->formname)?>
</div>
<div class="form-group">
	<?php echo $form->label('akID', t('PageSelector'))?>
	<?php echo $form->select('akID',$anserlist,$controller->akID)?>
</div>
<div class="form-group">
    <label class='control-label'><?php echo t('Number of Pages to Display') ?></label>
    <input type="text" name="num" value="<?php echo $num ?>" class="form-control">
</div>
<fieldset>
  <legend><?php echo t('Sort') ?></legend>
  <div class="form-group">
      <select name="orderBy" class="form-control">
          <option value="display_asc" <?php if ($orderBy == 'display_asc') { ?> selected <?php } ?>>
              <?php echo t('Sitemap order') ?>
          </option>
          <option value="chrono_desc" <?php if ($orderBy == 'chrono_desc') { ?> selected <?php } ?>>
              <?php echo t('Most recent first') ?>
          </option>
          <option value="chrono_asc" <?php if ($orderBy == 'chrono_asc') { ?> selected <?php } ?>>
              <?php echo t('Earliest first') ?>
          </option>
          <option value="alpha_asc" <?php if ($orderBy == 'alpha_asc') { ?> selected <?php } ?>>
              <?php echo t('Alphabetical order') ?>
          </option>
          <option value="alpha_desc" <?php if ($orderBy == 'alpha_desc') { ?> selected <?php } ?>>
              <?php echo t('Reverse alphabetical order') ?>
          </option>
          <option value="random" <?php if ($orderBy == 'random') { ?> selected <?php } ?>>
              <?php echo t('Random') ?>
          </option>
      </select>
  </div>
</fieldset>
<fieldset>
    <legend><?php echo t('Pagination') ?></legend>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="paginate" value="1" <?php if ($paginate == 1) { ?> checked <?php } ?> />
            <?php echo t('Display pagination interface if more items are available than are displayed.') ?>
        </label>
    </div>
</fieldset>