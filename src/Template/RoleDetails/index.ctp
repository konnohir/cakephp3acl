<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleDetail[] $role_details
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('新規作成'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="roleDetails index large-9 medium-8 columns content">
    <h3><?= __('Role Details') ?></h3>
    <table>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roleDetails as $roleDetail): ?>
            <tr>
                <td><?= h($roleDetail->id) ?></td>
                <td><?= h($roleDetail->name) ?></td>
                <td><?= h($roleDetail->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $roleDetail->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $roleDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $roleDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleDetail->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
