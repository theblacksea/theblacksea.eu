<div class="plus">
  <?php foreach($data as $k => $paragraph): ?>
    <p>
      <?php if($k == 0): ?> <span class="plus-sign">&plus;</span> <?php endif; ?>
      <?=$paragraph;?>
    </p>
  <?php endforeach; ?>
</div>