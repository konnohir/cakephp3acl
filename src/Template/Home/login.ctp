<div class="home login columns content">
    <h3><?= __('Login') ?></h3>
    <?php
    echo $this->Form->create();
    echo $this->Form->control('name');
    echo $this->Form->control('password');
    echo $this->Form->button('Login');
    echo $this->Form->end();

    ?>
</div>
