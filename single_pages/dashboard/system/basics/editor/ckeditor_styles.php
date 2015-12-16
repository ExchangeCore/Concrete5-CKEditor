<?php defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @var string $styles
 * @var string $tokenOutput
 */
?>
<style>
    .textarea textarea{
        width: 100%;
    }
</style>
<form method="post" action="<?= $view->action('submit') ?>">
    <?= $this->controller->token->output('submit') ?>
    <fieldset>
        <p class="lead"><?= t('CKEditor Styles') ?></p>

        <div class="textarea">
            <textarea rows="15" name="styles"><?= $styles ?></textarea>
        </div>
    </fieldset>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right btn btn-primary" type="submit"><?= t('Save') ?></button>
        </div>
    </div>
</form>