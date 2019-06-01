<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleDetail $roleDetail
 */
?>
<div class="roleDetails view columns content">
    <h3><?= h($roleDetail->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($roleDetail->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($roleDetail->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $roleDetail->id ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Acos') ?></h4>
        <?php if (!empty($roleDetail->acos)): ?>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Parent Id') ?></th>
                <th><?= __('Alias') ?></th>
            </tr>
            <?php foreach ($roleDetail->acos as $acos): ?>
            <tr>
                <td><?= h($acos->id) ?></td>
                <td><?= h($acos->parent_id) ?></td>
                <td><?= h($acos->alias) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
