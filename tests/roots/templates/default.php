<?= t('my.name') ?>
<?= t('test.plural=c.other') ?>
<?php var_dump(p('test.plural=c', 0)); ?>
<?php var_dump(p('test.plural=c', '0.1')); ?>
<?php var_dump(p('test.plural=r', 3, 4, 'John')); ?>