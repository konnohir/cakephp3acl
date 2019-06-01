<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 * @var \App\Model\Entity\RoleDetails[] $roleDetails
 */
?>
<div class="roles form columns content">
    <?= $this->Form->create($role) ?>
    <fieldset>
        <legend><?= $role->isNew() ? __('Add Role') : __('Edit Role') ?></legend>
        <?php
            echo $this->Form->hidden('_lock', ['default' => $role->updated_at]);
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('role_details._ids', ['options' => $roleDetails]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
