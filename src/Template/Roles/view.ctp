<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="roles view columns content">
    <h3><?= h($role->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($role->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($role->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $role->id ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Role Details') ?></h4>
        <?php if (!empty($role->role_details)): ?>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Description') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($role->role_details as $roleDetails): ?>
            <tr>
                <td><?= h($roleDetails->id) ?></td>
                <td><?= h($roleDetails->name) ?></td>
                <td><?= h($roleDetails->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RoleDetails', 'action' => 'view', $roleDetails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RoleDetails', 'action' => 'edit', $roleDetails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RoleDetails', 'action' => 'delete', $roleDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleDetails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    </div>
</div>
