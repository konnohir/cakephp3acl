<div class="roleDetails form columns content">
    <?= $this->Form->create($roleDetail) ?>
    <fieldset>
        <legend><?= $roleDetail->isNew() ? __('Add Role Detail') : __('Edit Role Detail') ?></legend>
        <?php
            echo $this->Form->hidden('_lock', ['default' => $roleDetail->updated_at]);
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->hidden('acos._ids[]', ['value' => '']);
            foreach($acos as $parent) {
                foreach($parent->children as $controller) {
                    if (!$controller->children) {
                        continue;
                    }
                    echo $this->Form->control('controller.'.$controller->alias, [
                        'type' => 'checkbox',
                        'label' => $controller->alias,
                        'hiddenField' => false,
                        'data-parent' => $controller->id,
                        'value' => false,
                        'name' => false,
                    ]);
                    foreach($controller->children as $action) {
                        echo $this->Form->control('acos._ids', [
                            'multiple' => 'checkbox',
                            'options' => [$action->id => $action->alias."($action->id)"],
                            'label' => false,
                            'hiddenField' => false,
                            'style' => 'margin-left:4em',
                            'data-child' => $controller->id,
                        ]);
                    }
                }
            }
            //echo $this->Form->control('acos._ids', ['options' => $acos,'multiple' => 'checkbox']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
<script>
$('[data-parent]').click(function() {
    var id = $(this).attr('data-parent');
    var checked = $(this).prop('checked');
    $('[data-child=' + id + ']').prop('checked', checked);
}).each(function() {
    var id = $(this).attr('data-parent');
    var num1 = $('[data-child=' + id + ']').length;
    var num2 = $('[data-child=' + id + ']:checked').length;
    var checked = (num1 == num2);
    $('[data-parent=' + id + ']').prop('checked', checked);
});
$('[data-child]').click(function() {
    var id = $(this).attr('data-child');
    var num1 = $('[data-child=' + id + ']').length;
    var num2 = $('[data-child=' + id + ']:checked').length;
    var checked = (num1 == num2);
    $('[data-parent=' + id + ']').prop('checked', checked);
});

</script>