<?php foreach($data as $minus): ?>
  <div class="minus">
    <?php foreach($minus as $k => $paragraph): ?>
      <p>
        <?php if($k == 0): ?> <span class="minus-dash">&mdash;</span> <?php endif; ?>
        <?=$paragraph;?>
      </p>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>