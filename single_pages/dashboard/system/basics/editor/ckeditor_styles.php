<?php defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @var string $styles
 * @var string $tokenOutput
 */
?>
<form method="post" class="ccm-dashboard-content-form" action="<?=$view->action('submit')?>">
    <?=$this->controller->token->output('submit')?>
    <fieldset>
        <p class="lead"><?=t('CKEditor Styles')?></p>
        <div class="textarea">
            <textarea rows="15" cols="400" name="styles"><?= $styles ?></textarea>
        </div>
    </fieldset>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right btn btn-primary" type="submit" ><?=t('Save')?></button>
        </div>
    </div>
</form>