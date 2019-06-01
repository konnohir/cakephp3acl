<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= $user->isNew() ? __('Add User') : __('Edit User') ?></legend>
        <?php
            echo $this->Form->hidden('_lock', ['default' => $user->updated_at]);
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('role_id', ['options' => $roles]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
